<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * MIGRATION EXAMPLE: CodeIgniter Welcome Controller to Laravel
 * 
 * CodeIgniter Pattern:
 * - Controllers extend CI_Controller or custom MY_Controller
 * - Load libraries, helpers, models in __construct
 * - Views loaded with $this->load->view()
 * - Data passed as array to views
 * 
 * Laravel Pattern:
 * - Controllers extend Controller class
 * - Dependency injection in constructor or methods
 * - Views returned using view() helper
 * - Data passed as array or compact()
 */
class WelcomeController extends Controller
{
    /**
     * Display the home page
     * 
     * CodeIgniter (Original):
     * public function index()
     * {
     *     $menu_list = $this->cms_menu_model->getBySlug('main-menu');
     *     $this->data['main_menus'] = $this->cms_menuitems_model->getMenus($menu_list['id']);
     *     $this->data['page'] = $this->cms_page_model->getBySlug($home_page_slug);
     *     $this->load_theme('home');
     * }
     * 
     * Laravel (Converted):
     */
    public function index()
    {
        // Instead of loading models in constructor, use dependency injection or facades
        // $page = CmsPage::where('slug', 'home')->first();
        
        // Example with simple data
        $hospitalName = config('app.name');
        
        return view('welcome.index', [
            'hospitalName' => $hospitalName,
            'message' => 'Welcome to the Hospital Management System'
        ]);
    }

    /**
     * Display a specific page
     * 
     * CodeIgniter (Original):
     * public function page($slug)
     * {
     *     $page = $this->cms_page_model->getBySlug($slug);
     *     if (!$page) {
     *         $this->data['page'] = $this->cms_page_model->getBySlug('404-page');
     *     }
     *     $this->load_theme('pages/page');
     * }
     * 
     * Laravel (Converted):
     */
    public function page($slug)
    {
        // Eloquent with fallback to 404
        // $page = CmsPage::where('slug', $slug)->firstOrFail();
        
        return view('pages.page', compact('slug'));
    }

    /**
     * Display appointment form - GET request
     * 
     * CodeIgniter approach used both GET and POST in same method
     * Laravel separates GET (show form) and POST (process form)
     */
    public function showAppointmentForm()
    {
        // $specialists = Staff::where('role', 'doctor')->get();
        
        return view('appointment.form');
    }

    /**
     * Process appointment - POST request
     * 
     * CodeIgniter (Original):
     * public function appointment()
     * {
     *     $this->form_validation->set_rules('doctor', 'Doctor', 'required');
     *     if ($this->form_validation->run()) {
     *         $this->onlineappointment_model->addAppointment($data);
     *     }
     * }
     * 
     * Laravel (Converted):
     */
    public function storeAppointment(Request $request)
    {
        // Laravel's built-in validation replaces CodeIgniter's form_validation
        $validated = $request->validate([
            'doctor' => 'required',  // In production: 'required|exists:staff,id'
            'specialist' => 'required',
            'date' => 'required|date',
            'shift' => 'required',
            'slot' => 'required',
            'message' => 'required|string',
        ]);

        // Use Eloquent ORM instead of Query Builder
        // In production:
        // $appointment = Appointment::create([
        //     'patient_id' => auth()->id(),
        //     'doctor_id' => $validated['doctor'],
        //     'specialist' => $validated['specialist'],
        //     'appointment_date' => $validated['date'],
        //     'shift' => $validated['shift'],
        //     'time_slot' => $validated['slot'],
        //     'message' => $validated['message'],
        //     'status' => 'pending',
        // ]);

        return redirect()
            ->route('appointment.form')
            ->with('success', 'Appointment booked successfully! (This is a demo - no data was saved)');
    }
}
