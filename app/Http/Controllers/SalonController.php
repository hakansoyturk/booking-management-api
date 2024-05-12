<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Salon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SalonController extends Controller
{
    public function index()
    {
        try {
            return ResponseHelper::createResponse(
                'Salons fetched successfully',
                Salon::all(),
                Response::HTTP_CREATED
            );
        } catch (Exception $e) {
            return ResponseHelper::handleException(
                'An error occurred while registering the user',
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
