<?php 
namespace Database\Seeders; 
use App\Models\LeaveCategory; 
use Illuminate\Database\Seeder; 
class LeaveCategorySeeder extends Seeder{
    public function run() { 
        // LeaveCategory::create([ 
        //     'name' => 'Annual Leave', 
        //     'annual_entitlement' => 15, ]); 
        // LeaveCategory::create([ 
        //     'name' => 'Sick Leave', 
        //     'annual_entitlement' => 15, ]);
        // LeaveCategory::create([ 
        //     'name' => 'Un-paid Leave', 
        //     'annual_entitlement' => 60, ]);

            LeaveCategory::create([
                'name' => 'annual leave', 
            'annual_entitlement' => 15, ]);     
            
            LeaveCategory::create([
                'name' => 'sick leave', 
            'annual_entitlement' => 15, ]); 

            LeaveCategory::create([
                'name' => 'unpaid leave', 
            'annual_entitlement' => 60, ]); 
        } // Add more records... } }   
}