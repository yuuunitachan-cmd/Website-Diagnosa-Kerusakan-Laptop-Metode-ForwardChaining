<?php

namespace App\Services;

use App\Models\BasisPengetahuan;
use App\Models\Kerusakan;
use App\Models\Gejala;
use Illuminate\Support\Collection;

class ForwardChainingService
{
    protected $workingMemory;
    protected $rulesTriggered;
    protected $conclusions = [];  // UBAH: Array biasa, bukan Collection
    protected $diagnosisSteps;

    public function getGejalaByKategori()
    {
        return Gejala::with('basisPengetahuan.kerusakan')
            ->aktif()
            ->get()
            ->groupBy('kategori');
    }

    public function prosesDiagnosa(array $gejalaIds): array
    {
        // Inisialisasi
        $this->workingMemory = collect($gejalaIds);
        $this->rulesTriggered = collect();
        $this->conclusions = [];  // Reset ke array kosong
        $this->diagnosisSteps = collect();

        $stepNumber = 1;
        $changed = true;

        // Langkah 1
        $this->addStep($stepNumber, "Memulai analisis dengan gejala yang dipilih", 
                      $this->workingMemory->toArray(), []);

        // Main inference loop - FORWARD CHAINING MURNI
        while ($changed) {
            $changed = false;
            
            $rules = BasisPengetahuan::with(['kerusakan', 'gejala'])
                ->where('is_aktif', true)
                ->orderBy('urutan')
                ->get();

            foreach ($rules as $rule) {
                if ($this->isRuleTriggered($rule->id)) continue;
                
                if ($this->isPremiseTerpenuhi($rule)) {
                    $this->triggerRule($rule, $stepNumber);
                    $changed = true;
                    $stepNumber++;
                }
            }
        }

        return $this->formatHasilDiagnosa();
    }

    protected function triggerRule($rule, $stepNumber): void
    {
        $this->rulesTriggered->push([
            'id' => $rule->id,
            'step' => $stepNumber,
            'rule' => "IF {$rule->gejala->kode_gejala} THEN {$rule->kerusakan->kode_kerusakan}",
            'gejala_nama' => $rule->gejala->nama_gejala,
            'kerusakan_nama' => $rule->kerusakan->nama_kerusakan,
            'kerusakan_id' => $rule->kerusakan_id
        ]);

        // PERBAIKAN DI SINI: Gunakan array biasa
        $kerusakanId = $rule->kerusakan_id;
        
        if (!isset($this->conclusions[$kerusakanId])) {
            $this->conclusions[$kerusakanId] = [
                'kerusakan' => $rule->kerusakan,
                'total_rules' => 1
            ];
        } else {
            $this->conclusions[$kerusakanId]['total_rules']++;
        }

        $this->addStep($stepNumber, 
            "Rule triggered: {$rule->gejala->kode_gejala} → {$rule->kerusakan->kode_kerusakan}",
            $this->workingMemory->toArray(), 
            array_keys($this->conclusions)  // Langsung dari array
        );
    }

    protected function addStep($stepNumber, $action, $workingMemory, $conclusions): void
    {
        $this->diagnosisSteps->push([
            'step' => $stepNumber,
            'action' => $action,
            'working_memory' => $workingMemory,
            'conclusions' => $conclusions
        ]);
    }

    protected function isPremiseTerpenuhi($rule): bool
    {
        return $this->workingMemory->contains($rule->gejala_id);
    }

    protected function isRuleTriggered($ruleId): bool
    {
        return $this->rulesTriggered->contains('id', $ruleId);
    }

    protected function formatHasilDiagnosa(): array
    {
        $kesimpulanAkhir = $this->getKesimpulanAkhir();
        
        return [
            'fakta_terbukti' => $this->workingMemory->toArray(),
            'rules_tertrigger' => $this->rulesTriggered->toArray(),
            'langkah_diagnosa' => $this->diagnosisSteps->toArray(),
            'kesimpulan_akhir' => $kesimpulanAkhir,
            'semua_kemungkinan' => $this->getSemuaKemungkinan(),
            'total_rules_tertrigger' => $this->rulesTriggered->count(),
            'total_langkah' => $this->diagnosisSteps->count()
        ];
    }

    protected function getKesimpulanAkhir()
    {
        if (empty($this->conclusions)) {
            return null;
        }

        // PERBAIKAN: Convert ke array dan sort
        $sortedConclusions = $this->conclusions;
        
        // Sort berdasarkan total_rules tertinggi
        usort($sortedConclusions, function($a, $b) {
            return $b['total_rules'] <=> $a['total_rules'];
        });

        $tertinggi = $sortedConclusions[0];
        
        return [
            'kerusakan' => $tertinggi['kerusakan'],
            'total_rules' => $tertinggi['total_rules']
        ];
    }

    protected function getSemuaKemungkinan()
    {
        if (empty($this->conclusions)) {
            return [];
        }

        $sortedConclusions = $this->conclusions;
        
        // Sort berdasarkan total_rules tertinggi
        usort($sortedConclusions, function($a, $b) {
            return $b['total_rules'] <=> $a['total_rules'];
        });

        return $sortedConclusions;
    }
}