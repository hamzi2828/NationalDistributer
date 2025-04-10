<?php

namespace App\Http\Services;

use App\Models\Tax;

class TaxService
{
    /**
     * Get all taxes, ordered by latest
     *
     * @return mixed
     */
    public function all()
    {
        return Tax::latest()->get();
    }

    /**
     * Save a new tax
     *
     * @param \Illuminate\Http\Request $request
     * @return Tax
     */
    public function save($request)
    {
        return Tax::create([
           'user_id' => auth () -> user () -> id,
            'title'   => $request->input('title'),
            'rate'    => $request->input('rate'),
        ]);
    }

    /**
     * Update an existing tax
     *
     * @param \Illuminate\Http\Request $request
     * @param Tax $tax
     * @return bool
     */
    public function edit($request, Tax $tax)
    {
        return $tax->update([
           'user_id' => auth () -> user () -> id,
            'title'   => $request->input('title'),
            'rate'    => $request->input('rate'),
        ]);
    }

    /**
     * Delete a tax
     *
     * @param Tax $tax
     * @return bool|null
     */
    public function delete(Tax $tax)
    {
        return $tax->delete();
    }
}
