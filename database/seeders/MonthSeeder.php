<?php
    
    namespace Database\Seeders;
    
    use App\Models\MonthModel;
    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    
    class MonthSeeder extends Seeder {
        
        /**
         * Run the database seeds.
         * @return void
         */
        
        public function run () {
            $array = [
                [
                    'title'        => 'January',
                    'short_name'   => 'Jan',
                    'month_number' => 1
                ],
                [
                    'title'        => 'February',
                    'short_name'   => 'Feb',
                    'month_number' => 2
                ],
                [
                    'title'        => 'March',
                    'short_name'   => 'Mar',
                    'month_number' => 3
                ],
                [
                    'title'        => 'April',
                    'short_name'   => 'Apr',
                    'month_number' => 4
                ],
                [
                    'title'        => 'May',
                    'short_name'   => 'May',
                    'month_number' => 5
                ],
                [
                    'title'        => 'June',
                    'short_name'   => 'Jun',
                    'month_number' => 6
                ],
                [
                    'title'        => 'July',
                    'short_name'   => 'Jul',
                    'month_number' => 7
                ],
                [
                    'title'        => 'August',
                    'short_name'   => 'Aug',
                    'month_number' => 8
                ],
                [
                    'title'        => 'September',
                    'short_name'   => 'Sep',
                    'month_number' => 9
                ],
                [
                    'title'        => 'October',
                    'short_name'   => 'Oct',
                    'month_number' => 10
                ],
                [
                    'title'        => 'November',
                    'short_name'   => 'Nov',
                    'month_number' => 11
                ],
                [
                    'title'        => 'December',
                    'short_name'   => 'Dec',
                    'month_number' => 12
                ],
            ];
            
            foreach ( $array as $value ) {
                MonthModel ::create ( $value );
            }
        }
    }
