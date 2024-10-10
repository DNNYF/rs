<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\RawatJalan;
use Illuminate\Http\Request;
use App\Models\RawatJalanObat;
use App\Models\RawatJalanSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RawatJalanController extends Controller
{
    protected $steps = [
        1 => ['view' => 'rawat-jalan.index', 'data' => ['pasiens', 'dokters']],
        2 => ['view' => 'rawat-jalan.index', 'data' => ['obats']],
        3 => ['view' => 'rawat-jalan.index'],
    ];

    protected $validationRules = [
        1 => [
            'pasien_id' => 'required|exists:pasiens,id',
            'dokter_id' => 'required|exists:dokters,id',
        ],
        2 => [
            'obat_id' => 'required|array',
            'obat_id.*' => 'exists:obats,id_obat',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
        ],
        3 => [
            'total_biaya' => 'required|numeric|min:0',
        ],
    ];

    public function index(Request $request)
    {   
        $id = $request->query('id');
        $rawat_jalan_data = null;

        if ($id) {
            $session = RawatJalanSession::find($id);
            if ($session) {
                $rawat_jalan_data = [
                    'id' => $session->id,
                    'pasien_id' => $session->pasien_id,
                    'dokter_id' => $session->dokter_id,
                    'obat_list' => $session->obat_list ? json_decode($session->obat_list, true) : [],
                    'step' => $session->step,
                ];
                $request->session()->put('rawat_jalan_data', $rawat_jalan_data);
                $request->session()->put('rawat_jalan_step', $session->step);
            }
        }

        if (!$rawat_jalan_data) {
            $rawat_jalan_data = $request->session()->get('rawat_jalan_data', []);
        }
        
        $pasiens = Pasien::all();
        $dokters = Dokter::all();
        $obats = Obat::all();
        $rawatJalanSessions = RawatJalanSession::with('pasien')->get();

        $step = $request->session()->get('rawat_jalan_step', $rawat_jalan_data['step'] ?? 1);
        
        if (!isset($this->steps[$step])) {
            return redirect()->route('rawat-jalan.index')->with('error', 'Invalid step');
        }

        $viewData = [
            'step' => $step,
            'rawat_jalan_data' => $rawat_jalan_data,
            'pasiens' => $pasiens,
            'dokters' => $dokters,
            'obats' => $obats,
            'rawatJalanSessions' => $rawatJalanSessions,
        ];

        return view($this->steps[$step]['view'], $viewData);
    }


    public function store(Request $request)
{
    Log::info('Start of store method', ['request' => $request->all()]);

    $action = $request->input('action');
    $step = $request->input('step');
    $rawat_jalan_data = $request->session()->get('rawat_jalan_data', []);

    Log::info('Initial state', [
        'action' => $action,
        'step' => $step,
        'rawat_jalan_data' => $rawat_jalan_data
    ]);

    if ($action == 'dumpSession') {
        $request->session()->forget(['rawat_jalan_step', 'rawat_jalan_data']);
        return redirect()->route('rawat-jalan.index')->with('success', 'Sesi baru berhasil dibuat.');
    }

    if ($action === 'previous') {
        $step--;
    } elseif ($action === 'next' || $action === 'finish') {
        $this->validateStep($request, $step);

        // Tambahkan $step ke dalam rawat_jalan_data
        $rawat_jalan_data['step'] = $step;

        if ($step == 2) {
            $obat_ids = array_filter($request->input('obat_id', []), 'is_string');
            $jumlah = array_filter($request->input('jumlah', []), 'is_string');
            
            // Merge cleaned arrays into session data
            $rawat_jalan_data = array_merge($rawat_jalan_data, [
                'obat_id' => array_values($obat_ids),
                'jumlah' => array_values($jumlah),
                'total_biaya' => $request->input('total_biaya'),
            ]);
        } else {
            $rawat_jalan_data = array_merge($rawat_jalan_data, $request->only(array_keys($this->validationRules[$step])));
        }

        // Step 1 logic
        if ($step == 1) {
            RawatJalanSession::updateOrCreate(
                ['pasien_id' => $rawat_jalan_data['pasien_id']],
                [
                    'dokter_id' => $rawat_jalan_data['dokter_id'],
                    'step' => $step + 1, // Simpan $step ke dalam rawat_jalan_sessions
                ]
            );
        }

        // Step 2 logic (store session for obat)
        elseif ($step == 2) {
            $sessionId = $rawat_jalan_data['pasien_id'];
            $session = RawatJalanSession::where('pasien_id', $sessionId)->first();

            if ($session) {
                $session->update([
                    'obat_list' => json_encode($rawat_jalan_data['obat_id']),
                    'step' => $step + 1, // Simpan $step ke dalam rawat_jalan_sessions
                ]);
            } else {
                return redirect()->route('rawat-jalan.index')->with('error', 'Session Not Found!');
            }
        }

        // Step 3 logic (finalize and save to database)
        if ($action === 'finish' && $step == 3) {
            DB::transaction(function () use ($rawat_jalan_data) {
                $rawatJalan = RawatJalan::create([
                    'pasien_id' => $rawat_jalan_data['pasien_id'],
                    'dokter_id' => $rawat_jalan_data['dokter_id'],
                    'total_biaya' => $rawat_jalan_data['total_biaya'],
                ]);

                $this->storeRawatJalanObat($rawat_jalan_data['obat_id'], $rawat_jalan_data['jumlah'], $rawatJalan->id);

                RawatJalanSession::where('pasien_id', $rawat_jalan_data['pasien_id'])->delete();
            });

            $request->session()->forget(['rawat_jalan_step', 'rawat_jalan_data']);
            return redirect()->route('rawat-jalan.index')->with('success', 'Data rawat jalan berhasil disimpan.');
        }
        $step++;
    }

    $request->session()->put('rawat_jalan_data', $rawat_jalan_data);
    $request->session()->put('rawat_jalan_step', $step);

    return redirect()->route('rawat-jalan.index');
}

    
    protected function validateStep(Request $request, $step)
    {
        $request->validate($this->validationRules[$step]);
    }

    protected function storeRawatJalanObat(array $obatIds, array $jumlah, $rawatJalanId)
    {
        Log::info('Start of storeRawatJalanObat', [
            'obatIds' => $obatIds,
            'jumlah' => $jumlah,
            'rawatJalanId' => $rawatJalanId
        ]);

        // Ensure both arrays match in size
        if (count($obatIds) !== count($jumlah)) {
            Log::error('Mismatch between obatIds and jumlah arrays');
            throw new \InvalidArgumentException('Jumlah obat tidak sesuai dengan ID obat yang diberikan.');
        }

        // Create associative array to avoid duplicate entries
        $obatData = [];
        foreach ($obatIds as $index => $obatId) {
            $id_obat = (int) $obatId;
            $quantity = (int) $jumlah[$index];

            Log::info('Processing obat', [
                'index' => $index,
                'id_obat' => $id_obat,
                'quantity' => $quantity
            ]);

            if ($id_obat <= 0 || $quantity <= 0) {
                Log::warning('Invalid obat data, skipping', [
                    'id_obat' => $id_obat,
                    'quantity' => $quantity
                ]);
                continue;
            }

            if (isset($obatData[$id_obat])) {
                Log::info('Obat already exists, adding quantity', [
                    'id_obat' => $id_obat,
                    'old_quantity' => $obatData[$id_obat],
                    'added_quantity' => $quantity
                ]);
                $obatData[$id_obat] += $quantity;
            } else {
                $obatData[$id_obat] = $quantity;
            }

            Log::info('Obat processed', [
                'id_obat' => $id_obat,
                'final_quantity' => $obatData[$id_obat]
            ]);
        }

        Log::info('Processed obat data', ['obatData' => $obatData]);

        // Save the combined data
        foreach ($obatData as $id_obat => $quantity) {
            Log::info('Saving obat', [
                'id_obat' => $id_obat,
                'quantity' => $quantity
            ]);

            $createdRecord = RawatJalanObat::create([
                'rawat_jalan_id' => (int) $rawatJalanId,
                'obat_id' => $id_obat,
                'jumlah' => $quantity,
            ]);

            Log::info('Created record', $createdRecord->toArray());
        }

        // Verify saved data
        $savedRecords = RawatJalanObat::where('rawat_jalan_id', $rawatJalanId)->get();
        Log::info('All saved records', $savedRecords->toArray());

        Log::info('End of storeRawatJalanObat');
    }
}
