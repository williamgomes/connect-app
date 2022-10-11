<?php

namespace App\Http\Livewire\Faq;

use App\Models\Faq;
use App\Models\FaqCategory;
use Livewire\Component;

class Search extends Component
{
    public $search;

    public function render()
    {
        if ($this->search) {
            $faqsWithCategories = Faq::whereHas('category', function ($query) {
                $query->where('faq_categories.name', 'like', '%' . $this->search . '%')
                    ->where('faq_categories.active', FaqCategory::IS_ACTIVE);
            })
                ->where('faq.active', Faq::IS_ACTIVE)
                ->get();

            $faqs = Faq::where(function ($query) {
                $query->where('faq.title', 'like', '%' . $this->search . '%')
                    ->orWhere('faq.content', 'like', '%' . $this->search . '%');
            })
                ->where('faq.active', Faq::IS_ACTIVE)
                ->whereNotIn('id', $faqsWithCategories->pluck('id'))
                ->get();
        } else {
            $faqs = collect([]);
            $faqsWithCategories = collect([]);
        }

        return view('livewire.faq.search')->with([
            'faqs'               => $faqs,
            'faqsWithCategories' => $faqsWithCategories,
        ]);
    }
}
