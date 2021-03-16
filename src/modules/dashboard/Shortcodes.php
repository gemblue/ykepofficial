<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard
 *	
 * Shortcode for Dashboard Module
 * 
 * @author Oriza
 */
class DashboardShortcode extends LexCallback 
{
    public function getTotalUsers()
	{
        $this->load->model('dashboard/Report_model');

        return number_format($this->Report_model->getTotalUsers());
    }

    public function getTotalCourses() {
        $this->load->model('dashboard/Report_model');

        return number_format($this->Report_model->getTotalCourses());
    }

    public function getTotalLessons() {
        $this->load->model('dashboard/Report_model');
        
        return number_format($this->Report_model->getTotalLessons());
    }
}