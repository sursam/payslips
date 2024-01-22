<?php

namespace App\Http\Resources\Excel;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data= [
            '#'=> random_int(1,5000),
            'Name' =>$this->name,
            'Menemonic'=> $this->menemonic,
            'Category' => $this->category?->rootAncestor?->name ?? $this->category?->name,
            'Sub Category' => $this->category?->rootAncestor ? $this->category?->name : '',
            'Brand'=> $this->brand?->name,
            'Description'=> $this->description,
            'Part Number'=> $this->part_number,
            'Rank Order'=> $this->rank_order,
            'Popular'=> (bool)$this->is_popular,
            'Special'=> (bool)$this->is_featured,
            'Tool Types'=> $this->tags->implode('name',','),
            'Price'=>$this->price ?? '',
            'List Price' => $this->list_price ?? '',
            'Special Price'=> $this->special_price ?? '',
            'Image'=> $this->latest_image
        ];
        foreach($this->specifications as $key=>$value){
            $collection= collect($value);
            $data[$key]= $collection->first()['value'];
        }
        if($this->seo?->body){
            foreach ($this->seo?->body as $mKey => $mValue) {
                $data[ucwords(str_replace("_"," ",$mKey))]= $mValue;
            }
        }
        return $data;
    }
}
