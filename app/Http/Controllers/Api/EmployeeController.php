<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Employee::with('division');

            if ($request->has('name') && !empty($request->name)) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }

            if ($request->has('division_id') && !empty($request->division_id)) {
                $query->where('division_id', $request->division_id);
            }

            $employees = $query->paginate(10);

            if ($employees->total() === 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data employees tidak ditemukan',
                ], 404);
            }

            $data = EmployeeResource::collection($employees->items());

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

    public function store(EmployeeRequest $request)
    {
        $validated = $request->validated();

        try {
            Employee::create($validated);
            return response()->json([
                'status' => 'success',
                'message' => 'Employee berhasil ditambahkan',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menambahkan employee',
            ], 500);
        }
    }

    public function update(EmployeeRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            $employee = Employee::findOrFail($id);
            $employee->update($validated);
            return response()->json([
                'status' => 'success',
                'message' => 'Employee berhasil diupdate',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Employee tidak ditemukan',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengupdate employee',
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Employee berhasil dihapus',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Employee tidak ditemukan',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus employee',
            ], 500);
        }
    }
} 