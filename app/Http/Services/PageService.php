<?php
    
    namespace App\Http\Services;
    
    use App\Models\Category;
    use App\Models\Page;
    use App\Services\GeneralService;
    
    class PageService {
        
        public function all () {
            return Page ::get ();
        }
        
        public function save ( $request ): mixed {
            return Page ::create ( [
                                       'user_id'   => auth () -> user () -> id,
                                       'content'   => $request -> input ( 'content' ),
                                       'page_name' => $request -> input ( 'page-name' ),
                                   ] );
        }
        
        public function edit ( $request, $page ): void {
            $page -> user_id   = auth () -> user () -> id;
            $page -> content   = $request -> input ( 'content' );
            $page -> page_name = $request -> input ( 'page-name' );
            $page -> update ();
        }
        
        public function delete ( $page ): void {
            $page -> delete ();
        }
    }