<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Survey;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Resources\SurveyResource;
use App\Http\Requests\StoreSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $surveys = Survey::where('user_id', $user->id)->paginate();

        return SurveyResource::collection($surveys);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSurveyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSurveyRequest $request)
    {
        $data = $request->validated();

        if (isset($data['image'])) {
            $relativePath = $this->saveImage($data['image']);
            $data['image'] = $relativePath;
        }

        $survey = Survey::create($data);

        return new SurveyResource($survey);
    }
    private function saveImage($image)
    {
        //check if our image is valid base64 string or not
        // data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgA => base64 example
        if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
                //take out the base64 encoded text without mime type
            $image = substr($image, strpos($image, ',')+1);  //everything after ,
            //get file type
            $type = strtolower($type[1]);  //jpg , png , gif
            //check if file is image
            if (!in_array($type, ['jpg','png','gif','jpeg'])) {
                throw new \Exception('Invalid image type');
            }
            $image = str_replace(' ', '+', $image);
            $image = base64_decode($image);
            if ($image === false) {
                throw new \Exception('Base64 decode failed');
            }
        } else {
            throw new \Exception('Did not match data url with image data');
        }

        $dir = 'images/';
        $file = Str::random().'.'.$type;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $file;
        //make dir in public folder
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 755, true);
        }
        file_put_contents($relativePath, $image);
        return $relativePath;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show(Survey $survey, Request $request)
    {
        if ($request->user()->id !== $survey->user_id) {
            return abort(403, 'Unauthorized Actions');
        }
        return new SurveyResource($survey);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSurveyRequest  $request
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSurveyRequest $request, Survey $survey)
    {
        // if ($request->user()->id !== $survey->user_id) {
        //     return abort(403, 'Unauthorized Actions');
        // }

        

        $data = $request->validated();
        if (isset($data['image'])) {
            $relativePath = $this->saveImage($data['image']);
            $data['image'] = $relativePath;

            if ($survey->image) {
                File::delete(public_path($survey->image));
            }
        }
        // return $request->user();
        $survey->update($data);
        return new SurveyResource($survey);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Survey $survey, Request $request)
    {
        if ($request->user()->id !== $survey->user_id) {
            return abort(403, 'Unauthorized Action');
        }
        $survey->delete();
        return response('', 200);
    }
}
