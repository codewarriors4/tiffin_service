<?php
namespace TiffinService\Http\Controllers\Admin;

use Illuminate\Http\Request;

use TiffinService\Http\Requests;
use TiffinService\Http\Controllers\Controller;
use TiffinService\User;

class ManageUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function showusers()
    {
        

       dd(\Storage::url('upload/81/license.jpg'));

        $users = User::all();
        return view('tsadmin.manageusers', ['users' => $users]);
    }

    public function blockuser($id)
    {
        try
        {
            $user = User::findOrFail($id);
        }
        // catch(Exception $e) catch any exception
        catch(ModelNotFoundException $e)
        {
            return response()->json(['success' => '0', 'msg' => 'Error']);
        }

        if ($user->UserAccountBlocked == 0)
        {
            $user->UserAccountBlocked = 1;
            $user->save();
            return response()->json(['success' => '1', 'msg' => 'User blocked', 'type' => 'block']);
        }else
        {

            $user->UserAccountBlocked = 0;
            $user->save();
            return response()->json(['success' => '1', 'msg' => 'User Unblocked', 'type' => 'unblock']);
        }

        $user->UserAccountBlocked = 1;
    }

     public function deleteuser($id)
    {

        try
        {
            $user = User::findOrFail($id);
        }
            // catch(Exception $e) catch any exception
        catch(ModelNotFoundException $e)
        {
            return response()->json(['success' => '0', 'msg' => 'Error']);
        }

        $user->delete();
        return response()->json(['success' => '1', 'msg' => 'User deleted', 'type' => 'delete']);
    }

    public function mutideleteusers($idarray = null)
    {

        if(preg_match('/^\d+(?:,\d+)*$/', $idarray))
        {
            $ids = explode(',', $idarray);
            foreach ($ids as $id)
            {
                $user = User::findorfail($id);
                $user->delete();

            }
            //changed
            return Redirect::back()->with('message','Selected users were deleted sucessfully');
        }
        else
            return Redirect::back()->withErrors('Something went wrong');

    }

    public function index()
    {

        //

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {

        //

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {

        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {

        //

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {

        //

    }
}
