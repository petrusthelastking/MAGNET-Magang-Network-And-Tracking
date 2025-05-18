<?php

namespace App\Livewire;

use Livewire\Component;

class DetailMahasiswa extends Component
{
    public $editMode = false;

    public $nama = 'Rafa Maharani';
    public $nim = '202320001';
    public $jurusan = 'Teknik Informatika';
    public $prodi = 'Sistem Informasi';
    public $jk = 'Perempuan';
    public $umur = '21';
    public $statusMagang = 'Aktif';

    // Metode untuk mengganti mode edit/simpan
    public function toggleEdit()
    {
        if ($this->editMode) {
            // Jika dalam mode edit, simpan data
            $this->saveData();
        } else {
            // Jika tidak dalam mode edit, aktifkan mode edit
            $this->editMode = true;
        }
    }

    // Metode untuk menyimpan data
    public function saveData()
    {
        // Di sini Anda dapat menambahkan logika untuk menyimpan data ke database
        // Contoh: Mahasiswa::where('nim', $this->nim)->update([...])
        
        // Setelah menyimpan, keluar dari mode edit
        $this->editMode = false;
        
        // Tambahkan notifikasi sukses jika diperlukan
        session()->flash('message', 'Data mahasiswa berhasil diperbarui');
    }

    public function render()
    {
        return view('detail-mahasiswa');
    }
}