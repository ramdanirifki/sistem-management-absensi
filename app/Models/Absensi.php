<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'pegawai_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status_masuk',
        'status_pulang',
        'latitude_masuk',
        'longitude_masuk',
        'latitude_pulang',
        'longitude_pulang',
        'catatan'
    ];

    protected $casts = [
        'tanggal' => 'date:Y-m-d',
    ];

    public $timestamps = true;

    /**
     * Accessor untuk menampilkan jam masuk dengan format H:i
     */
    public function getJamMasukFormattedAttribute()
    {
        if (!$this->jam_masuk) {
            return '--:--';
        }

        if (is_string($this->jam_masuk) && strlen($this->jam_masuk) >= 5) {
            return substr($this->jam_masuk, 0, 5);
        }

        try {
            return Carbon::parse($this->jam_masuk)->format('H:i');
        } catch (\Exception $e) {
            return (string) $this->jam_masuk;
        }
    }

    /**
     * Accessor untuk menampilkan jam pulang dengan format H:i
     */
    public function getJamPulangFormattedAttribute()
    {
        if (!$this->jam_pulang) {
            return '--:--';
        }

        if (is_string($this->jam_pulang) && strlen($this->jam_pulang) >= 5) {
            return substr($this->jam_pulang, 0, 5);
        }

        try {
            return Carbon::parse($this->jam_pulang)->format('H:i');
        } catch (\Exception $e) {
            return (string) $this->jam_pulang;
        }
    }

    /**
     * Accessor untuk mendapatkan Carbon instance dari jam masuk
     */
    public function getJamMasukCarbonAttribute()
    {
        if (!$this->jam_masuk || !$this->tanggal) {
            return null;
        }

        try {
            $tanggal = $this->tanggal instanceof \DateTime ?
                $this->tanggal->format('Y-m-d') :
                (string) $this->tanggal;

            return Carbon::parse($tanggal . ' ' . $this->jam_masuk);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Accessor untuk mendapatkan Carbon instance dari jam pulang
     */
    public function getJamPulangCarbonAttribute()
    {
        if (!$this->jam_pulang || !$this->tanggal) {
            return null;
        }

        try {
            $tanggal = $this->tanggal instanceof \DateTime ?
                $this->tanggal->format('Y-m-d') :
                (string) $this->tanggal;

            return Carbon::parse($tanggal . ' ' . $this->jam_pulang);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Accessor untuk mendapatkan lama kerja dalam menit
     */
    public function getLamaKerjaMenitAttribute()
    {
        $jamMasuk = $this->jam_masuk_carbon;
        $jamPulang = $this->jam_pulang_carbon;

        if (!$jamMasuk || !$jamPulang) {
            return 0;
        }

        return $jamPulang->diffInMinutes($jamMasuk);
    }

    /**
     * Accessor untuk mendapatkan lama kerja dalam format jam:menit
     */
    public function getLamaKerjaFormattedAttribute()
    {
        $totalMenit = $this->lama_kerja_menit;

        if ($totalMenit <= 0) {
            return '--:--';
        }

        $jam = floor($totalMenit / 60);
        $menit = $totalMenit % 60;

        return sprintf('%02d:%02d', $jam, $menit);
    }

    public function pegawai()
    {
        return $this->belongsTo(User::class, 'pegawai_id');
    }

    // Scopes
    public function scopeFilterTanggal($query, $tanggal)
    {
        if ($tanggal) {
            return $query->whereDate('tanggal', $tanggal);
        }
        return $query;
    }

    public function scopeFilterBulan($query, $bulan)
    {
        if ($bulan) {
            return $query->whereMonth('tanggal', $bulan);
        }
        return $query;
    }

    public function scopeFilterTahun($query, $tahun)
    {
        if ($tahun) {
            return $query->whereYear('tanggal', $tahun);
        }
        return $query;
    }

    public function scopeFilterPegawai($query, $pegawai_id)
    {
        if ($pegawai_id) {
            return $query->where('pegawai_id', $pegawai_id);
        }
        return $query;
    }
}
