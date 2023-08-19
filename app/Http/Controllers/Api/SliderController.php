<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\fileExists;

class SliderController extends Controller
{
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // check validator is fails the return 400 bad request
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 400);
        }

        // check if the image is not null then upload the image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/images_carousel');
            $image->move($destinationPath, $name);
        } else {
            $name = null;
        }

        // create new slider and save it to database
        $slider = new Slider();
        $slider->url = $request->url;
        $slider->image = $name;
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
        // update the slider
        $slider->url = $request->url;
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

        $oldImage = public_path('/images/images_carousel/' . $slider->image);
        if ($slider->image && fileExists($oldImage)) {
            unlink($oldImage);
        }
        // delete the slider
        $slider->delete();

        // return response json with success delete message
        return response()->json([
            'message' => 'Slider Deleted Successfully',
        ], 200);
    }
}
