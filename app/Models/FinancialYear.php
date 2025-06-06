<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    
    class FinancialYear extends Model {
        use HasFactory;
        
        protected $guarded = [];
        protected $table   = 'financial_year';
    }
