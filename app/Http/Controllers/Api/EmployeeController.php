<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Employee::with('division');

            // Filter by name
            if ($request->has('name') && !empty($request->name)) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }

            // Filter by division_id
            if ($request->has('division_id') && !empty($request->division_id)) {
                $query->where('division_id', $request->division_id);
            }

            $employees = $query->paginate(10);

            // Jika tidak ada data yang ditemukan, kembalikan response 404
            if ($employees->total() === 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data employees tidak ditemukan',
                ], 404);
            }

            $data = [];
            foreach ($employees->items() as $employee) {
                $data[] = [
                    'id' => $employee->id,
                    'image' => $employee->image,
                    'name' => $employee->name,
                    'phone' => $employee->phone,
                    'division' => [
                        'id' => $employee->division->id ?? null,
                        'name' => $employee->division->name ?? null,
                    ],
                    'position' => $employee->position,
                ];
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data employees berhasil diambil',
                'data' => [
                    'employees' => $data,
                ],
                'pagination' => [
                    'current_page' => $employees->currentPage(),
                    'last_page' => $employees->lastPage(),
                    'per_page' => $employees->perPage(),
                    'total' => $employees->total(),
                    'from' => $employees->firstItem(),
                    'to' => $employees->lastItem(),
                    'has_more_pages' => $employees->hasMorePages(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data employees',
                'data' => null,
            ], 500);
        }
    }
} 