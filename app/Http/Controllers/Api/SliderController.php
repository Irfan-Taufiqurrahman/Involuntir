<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\fileExists;

class SliderController extends Controller
{
    private function uploadImage(Request $request, $file, $judul_slug)
    {
        $fileName = $judul_slug . '.' . $request->file($file)->extension();
        $path = 'images/images_carousel';
        $request->file($file)->move(public_path($path), $fileName);

        return env('APP_URL') . "/$path/$fileName";
    }
    public function index()
    {
        // return full image url for each slider
        $sliders = Slider::all();
        foreach ($sliders as $slider) {
            $slider->image = config('app.url') . '/images/images_carousel/' . $slider->image;
        }

        return response()->json([
            'data' => $sliders,
        ]);
    }

    public function create(Request $request)
    {
        // make validator and response with json
        $validator = Validator::make($request->all(), [
            'url' => 'nullable|url',
            'title'=> 'required|nullable|string',
            'start_date'=> 'required|nullable|string',
            'end_date' => 'required|nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // check validator is fails the return 400 bad request
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $photo = $request->file('image');
        if (! empty($photo)) {
            $photo = $this->uploadImage($request, 'image', $request->title);
        }

        // create new slider and save it to database
        $slider = new Slider();
        $slider->url = $request->url;
        $slider->name = $request->title;
        $slider->start_date = $request->start_date;
        $slider->end_date = $request->end_date;
        $slider->image = $photo;
        $slider->save();

        // return response json with success message
        return response()->json([
            'message' => 'Slider Created Successfully',
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $slider = Slider::find($id);
        // create validation
        $validator = Validator::make($request->all(), [
            'url' => 'string|nullable',
        ]);

        // check validator is fails the return 400 bad request
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 400);
        }
        if (! $slider) {
            return response()->json([
                'message' => 'Slider Not Found',
            ], 404);
        }
        $photo = $request->file('image');
        if (! empty($photo)) {
            $photo = $this->uploadImage($request, 'image', $request->title);
        }
        // update the slider
        $slider->url = $request->url;
        $slider->name = $request->title;
        $slider->image = $photo;
        $slider->start_date = $request->start_date;
        $slider->end_date = $request->end_date;
        $slider->save();

        // return response json with success update message
        return response()->json([
            'message' => 'Slider Updated Successfully',
        ], 200);
    }

    public function delete($id)
    {
        $slider = Slider::find($id);
        if (! $slider) {
            return response()->json([
                'message' => 'Slider Not Found',
            ], 404);
        }

        $oldImagePath = public_path(env('APP_URL') . '/images/images_carousel/' . $slider->image);

        if ($slider->image && file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }
        
        // delete the slider
        $slider->delete();

        // return response json with success delete message
        return response()->json([
            'message' => 'Slider Deleted Successfully',
        ], 200);
    }
}
