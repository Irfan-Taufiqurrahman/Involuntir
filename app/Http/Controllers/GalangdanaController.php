<?php

namespace App\Http\Controllers;

use App\Models\Campaign;

class GalangdanaController extends Controller
{
    public function index()
    {
        $dataGalangdana = Campaign::all();

        return view('admin.pages.galangdana.index', compact('dataGalangdana'));
    }

    public function destroy(Campaign $id)
    {
        Campaign::destroy($id->id);

        return redirect('/galangdana')->with('success', 'Campaign berhasil dihapus');
    }

    public function edit(Campaign $id)
    {
        $campaignData = Campaign::findOrFail($id->id);
        // dd($campaign);
        return view('admin.pages.galangdana.edit', compact('campaignData'));
    }
}
