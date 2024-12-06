<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::paginate(10);
        return view('admin.driver.DataSupir', compact('drivers'));
    }

    public function create()
    {
        return view('admin.driver.createDriver');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:drivers,email',
            'address' => 'required|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $driver = new Driver();
        $driver->name = $request->name;
        $driver->phone = $request->phone;
        $driver->email = $request->email;
        $driver->address = $request->address;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('drivers', 'public');
            $driver->photo = $path;
        }

        $driver->save();

        return redirect()->route('drivers.index')->with('success', 'Sopir berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $driver = Driver::findOrFail($id);
        return view('admin.driver.editDriver', compact('driver'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:drivers,email,' . $id,
            'address' => 'required|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $driver = Driver::findOrFail($id);
        $driver->name = $request->name;
        $driver->phone = $request->phone;
        $driver->email = $request->email;
        $driver->address = $request->address;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('drivers', 'public');
            $driver->photo = $path;
        }

        $driver->save();

        return redirect()->route('drivers.index')->with('success', 'Sopir berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $driver = Driver::findOrFail($id);
        $driver->delete();

        return redirect()->route('drivers.index')->with('success', 'Sopir berhasil dihapus!');
    }
}
