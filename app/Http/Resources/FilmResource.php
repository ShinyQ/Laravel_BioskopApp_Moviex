<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FilmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      return [
      'id' => $this->id,
      'name' => $this->name,
      'gambar' => "http://localhost:2002/images/$this->image",
      'deskripsi' => $this->deskripsi,
      'waktu mulai' => date('H:i',strtotime($this->start_at)),
      'waktu selesai' => date('H:i',strtotime($this->end_at)),
      'kategori' => [
                     'id' => $this->genre_id,
                     'nama' =>  $this->genre->name
                    ],
      'studio' => [
                   'id' => $this->studio_id,
                   'nama' =>  $this->studio->name,
                   'kuota' => $this->studio->quota,
                   'harga' => 'Rp'.number_format($this->studio->price,2,',','.')
                  ]
      ];

    }
}
