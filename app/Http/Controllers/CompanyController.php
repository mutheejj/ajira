<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * Display a listing of companies.
     */
    public function index()
    {
        $companies = Company::paginate(12);
        return view('companies.index', compact('companies'));
    }

    /**
     * Display the specified company.
     */
    public function show(Company $company)
    {
        // Load the company's jobs
        $jobs = $company->jobs()->latest()->paginate(10);
        
        return view('companies.show', compact('company', 'jobs'));
    }
} 