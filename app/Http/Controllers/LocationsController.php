<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

use App\Location;
use App\LocationRegion as Region;
use App\LocationCountry as Country;
use App\LocationCity as City;

class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['regions'] = Region::with('countries')->get();
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
    public function store(Request $request)
    {
        $location = new Location();
        $location->region = $request->region;
        $location->city = $request->city;
        $location->street = $request->street;
        $location->save();

        if($location){
            return response()->json(array('success' => true, 'msg' => 'New location created!'));
        }else{
            return response()->json(array('success' => false, 'msg' => 'Something went wrong on the system, Please try again!'));
        }
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
        $location = Location::where('id', $request->id)->first();
        $location->region = $request->region;
        $location->city = $request->city;
        $location->street = $request->street;
        $location->save();

        if($location){
            return response()->json(array('success' => true, 'msg' => 'Llocation updated!'));
        }else{
            return response()->json(array('success' => false, 'msg' => 'Something went wrong on the system, Please try again!'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $location = Location::where('id', $request->id);
        $location->delete();

        if($location){
            return response()->json(array('success' => true, 'msg' => 'Location has been deleted!'));
        }else{
            return response()->json(array('success' => false, 'msg' => 'We cant delete this Page, please try again!'));
        }
    }

    public function getLocationDataJSON(Request $request){
        $location = Location::where('id',$request->id)->first();
        return response()->json($location);
    }

    public function countries(Request $request){
        $data['countries'] = Country::where('name', 'like', '%'.$request->search.'%')->get();

        return response()->json($data);
    }
    public function cities(Request $request){
        $data['cities'] = City::where('country', $request->country)->where('name','like','%'.$request->search.'%')->get();

        return response()->json($data);
    }
}
