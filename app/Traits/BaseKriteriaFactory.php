<?php

namespace App\Traits;

trait BaseKriteriaFactory
{
    public function forUser(int $mhs_id)
    {
        return $this->state(fn() => [
            'mahasiswa_id' => $mhs_id
        ]);
    }
    public function rank(int $rank)
    {
        return $this->state(fn() => [
            'rank' => $rank,
        ]);
    }
}
