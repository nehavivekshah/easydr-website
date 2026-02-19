<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Pages;
use App\Models\Cities;
use App\Models\States;
use App\Models\Countries;
use App\Models\PaymentGatewayConfig;
use App\Models\Video_call_gateway_configs;
use App\Models\Dosages;
use App\Models\Frequencies;
use App\Models\Durations;
use App\Models\Routes;
use App\Models\Meals;

class PageController extends ApiController
{
    public function pageContent($id)
    {
        // Fetch the page content by ID
        $page = Pages::find($id);

        // Check if the page exists
        if (!$page) {
            return response()->json(['error' => 'Page not found'], 404);
        }

        // Construct the HTML content <h1 class='text-center mt-4'>{$page->title}</h1>
        $htmlContent = "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>{$page->title}</title>
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                    background-color: #f9f9f9;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    margin-top: 0px;
                }
                .content {
                    padding: 0px 10px;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='content mt-4'>
                    {$page->content}
                </div>
            </div>
            <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
        </body>
        </html>
        ";

        // Return the HTML content as a response
        return response($htmlContent)->header('Content-Type', 'text/html');
    }

    public function getMeals(Request $request)
    {
        $meals = Meals::select('name')->where('status', '1')->get();

        return response()->json($meals);
    }

    public function getRoutes(Request $request)
    {
        $routes = Routes::select('name')->where('status', '1')->get();

        return response()->json($routes);
    }

    public function getDurations(Request $request)
    {
        $durations = Durations::select('name')->where('status', '1')->get();

        return response()->json($durations);
    }

    public function getFrequencies(Request $request)
    {
        $frequencies = Frequencies::select('name')->where('status', '1')->get();

        return response()->json($frequencies);
    }

    public function getDosages(Request $request)
    {
        $dosages = Dosages::select('name')->where('status', '1')->get();

        return response()->json($dosages);
    }

    public function videoCallGatewayConfigs(Request $request)
    {
        $videoCallGatewayConfigs = Video_call_gateway_configs::where('is_active', '1')->get();

        return response()->json($videoCallGatewayConfigs);
    }

    public function paymentGatewayConfigs(Request $request)
    {
        $paymentGatewayConfigs = PaymentGatewayConfig::where('is_active', '1')->get();

        return response()->json($paymentGatewayConfigs);
    }

    public function getCities(Request $request)
    {
        if (!empty($request->input('state_id'))) {

            $stateId = $request->input('state_id');
            $cities = Cities::select('name')->where('state', $stateId)->where('status', '1')->get();

        } elseif (!empty($request->input('country_id'))) {

            $countryId = $request->input('country_id');
            $cities = Cities::select('name')->where('country', $countryId)->where('status', '1')->get();

        } else {

            $cities = Cities::select('name')->where('status', '1')->get();

        }

        return response()->json($cities);
    }

    public function getStates(Request $request)
    {
        if (!empty($request->input('state_id'))) {

            $stateId = $request->input('state_id');
            $states = States::select('name')->where('name', $stateId)->where('status', '1')->get();

        } elseif (!empty($request->input('country_id'))) {

            $countryId = $request->input('country_id');
            $states = States::select('name')->where('country', $countryId)->where('status', '1')->get();

        } else {

            $states = States::select('name')->where('status', '1')->get();

        }

        return response()->json($states);
    }

    public function getCountries(Request $request)
    {
        if (!empty($request->input('country_id'))) {

            $countryId = $request->input('country_id');
            $countries = Countries::select('name')->where('name', $countryId)->where('status', '1')->get();

        } else {

            $countries = Countries::select('name')->where('status', '1')->get();

        }

        return response()->json($countries);
    }
}
