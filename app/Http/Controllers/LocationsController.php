<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

use App\Http\Requests\StoreLocationRequest;
use App\Location;
class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['locations'] = Location::all();
        #return response()->json($data);
        return view('admin.contents.locations', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLocationRequest $request)
    {
        $validated = $request->validated();

        $location = Location::create([
            'region' => $validated['region'],
            'country' => $request->country,
            'city' => $request->city
        ]);

        if($location)
            return response()->json(array('success' => true, 'msg' => 'New location created!'));
    }
    public function import(Request $request){
        $file = $request->file('file');
      
        // File Details 
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $tempPath = $file->getRealPath();
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();
    
        // Valid File Extensions
        $valid_extension = array("csv");
    
        // 2MB in Bytes
        $maxFileSize = 2097152; 
    
        // Check file extension
        if(in_array(strtolower($extension),$valid_extension)){
    
            // Check file size
            if($fileSize <= $maxFileSize){
    
            // File upload location
            $location = 'uploads';
    
            // Upload file
            $file->move($location,$filename);
    
            // Import CSV to Database
            $filepath = public_path($location."/".$filename);
    
            // Reading file
            $file = fopen($filepath,"r");
    
            $importData = array();
            $header = array();

            $i = 0;
                
            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($filedata );
                
                // Skip first row (Remove below comment if you want to skip the first row)
                if($i == 0){
                    for ($c=0; $c < $num; $c++) {
                        $header[$c] = Str::slug($filedata[$c], '_');
                    }
                    $i++;
                    continue; 
                }

                for ($c=0; $c < $num; $c++) {
                    $importData[$i][] = $filedata [$c];
                }

                $i++;
            }

            fclose($file);
            
            foreach($importData as $data){
               //0 Region, 1 Country, 2, City
               $region = Region::where('name',$data[0]);
               if(!$region->exists()){ //not exists
                   $region = Region::create([
                       'name' => $data[0]
                   ]);
               }else{
                   $region = $region->first();
               }
               
               $country = Country::where('region', $region->id)->where('name', $data[1]);
               if(!$country->exists()){ //not exists
                   $country = Country::create([
                       'region' => $region->id,
                       'name' => $data[1]
                   ]);
               }else{
                   $country = $country->first();
               }

               $city = City::where('country',$country->id)->where('name', $data[2]);
               if(!$city->exists()){ //not exists
                   $city = City::create([
                       'country' => $country->id,
                       'name' => $data[2]
                   ]);
               }
            }
            
            return response()->json(array('success' => true, 'msg' => 'File Import Successfully.'));

            }else{
            return response()->json(array('success' => false, 'msg' => 'File too large. File must be less than 2MB.'));
            }
    
        }else{
            return response()->json(array('success' => true, 'msg' => 'Invalid File Extension.'));
        }
    }

    public function importView(){
        return view('admin.contents.locations-import');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        switch($request->type){
            case 'region': 
                $region = Region::find($request->id);
                $region->name = $request->name;
                $region->save();
            break;
            case 'country': 
                $country = Country::find($request->id);
                $country->region = $request->region_id;
                $country->name = $request->name;
                $country->save();
            break;
            case 'city': 
                $city = City::find($request->id);
                $city->country = $request->country_id;
                $city->name = $request->name;
                $city->save();
            break;
        }

        return response()->json(array('success' => true, 'msg' => 'Location updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $delete = Location::find($request->id)->delete();
        
        if($delete)
            return response()->json(array('success' => true, 'msg' => 'Location has been deleted!'));
    }

    public function getLocationDataJSON(Request $request){
        $location = Location::find($request->id);
        return response()->json($location);
    }

    public function countries(Request $request){
        $data['countries'] = Country::where('name', 'like', '%'.$request->search.'%')->get();

        return response()->json($data);
    }
    public function cities(Request $request){
        $country = Country::where('name', $request->country)->first();
        $data['cities'] = City::where('country', $country->id)->where('name','like','%'.$request->search.'%')->get();

        return response()->json($data);
    }
}
