<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Http\Requests\StoreAppointmentRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Contracts\View\View
     * @return \Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $appointments = Appointment::paginate(5);
        // dd($appointments);
        return view('appointmentsScreen', compact('appointments'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'date'         => 'required',
            'hour'         => 'required',
            'fullName'     => 'required|max:50',
            'phoneNumber'  => 'required',
            'email'        => 'required|max:255',
        ]);

        if($validator->fails()){
            return redirect('/create')->with('errorMsg', 'All fields are required.');
        }
        else{
            $appointment                = new Appointment;
            $appointment->date          = $request->date;
            $appointment->hour          = $request->hour;
            $appointment->full_name     = $request->fullName;
            $appointment->phone_number  = $request->phoneNumber;
            $appointment->email         = $request->email;
        
        $appointment->save();
        
        return redirect('/')->with('successMsg', 'Product successfully added.');
     }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $appointment = Appointment::find($id);

        if($appointment){
            $appointment->delete();
        }

        return redirect('/')->with('successMsg', 'Appointment successfully deleted.');

    }

   /**
    * Get apointments by column value
    * @param string $value
    * @return \Illuminate\Http\Response
    */

    public function getAppointmentsByDate(string $value)
    {
        // $appointments = DB::select('select hour from appointments WHERE date = ?', [$value]);
        $hours = DB::table('appointments')
            ->select('hour')
            ->where('date', $value)
            ->get();

        return response()->json([
            'hours'=>$hours,
        ]);
    }
}