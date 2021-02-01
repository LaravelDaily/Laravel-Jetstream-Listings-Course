<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreListingRequest;
use App\Models\Category;
use App\Models\Color;
use App\Models\Listing;
use App\Models\Size;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listings = Listing::with(['categories', 'sizes', 'colors'])->get();

        return view('listings.index', compact('listings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $sizes = Size::all();
        $colors = Color::all();

        return view('listings.create',
            compact('categories', 'sizes', 'colors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreListingRequest $request)
    {
        $listing = auth()->user()->listings()->create($request->validated());

        for ($i=1; $i <= 3; $i++) {
            if ($request->hasFile('photo' . $i)) {
                $listing->addMediaFromRequest('photo' . $i)->toMediaCollection('listings');
            }
        }

        $listing->categories()->attach($request->categories);
        $listing->sizes()->attach($request->sizes);
        $listing->colors()->attach($request->colors);

        return redirect()->route('listings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function show(Listing $listing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function edit(Listing $listing)
    {
        $this->authorize('update', $listing);
        $listing->load('categories', 'sizes', 'colors');

        $media = $listing->getMedia('listings');
        $categories = Category::all();
        $sizes = Size::all();
        $colors = Color::all();

        return view('listings.edit',
            compact('listing', 'media', 'categories', 'sizes', 'colors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function update(StoreListingRequest $request, Listing $listing)
    {
        $this->authorize('update', $listing);

        $listing->update($request->validated());

        for ($i=1; $i <= 3; $i++) {
            if ($request->hasFile('photo' . $i)) {
                $listing->addMediaFromRequest('photo' . $i)->toMediaCollection('listings');
            }
        }

        $listing->categories()->sync($request->categories);
        $listing->sizes()->sync($request->sizes);
        $listing->colors()->sync($request->colors);

        return redirect()->route('listings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Listing $listing)
    {
        $this->authorize('delete', $listing);

        $listing->delete();

        return redirect()->route('listings.index');
    }

    public function deletePhoto($listingId, $photoId)
    {
        $listing = Listing::where('user_id', auth()->id())->findOrFail($listingId);

        $photo = $listing->getMedia('listings')->where('id', $photoId)->first();

        if ($photo) {
            $photo->delete();
        }

        return redirect()->route('listings.edit', $listingId);
    }
}
