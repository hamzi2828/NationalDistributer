<?php
    
    namespace App\Http\Services;
    
    use App\Models\Category;
    use App\Services\GeneralService;
    
    class CategoryService {
        
        public function all () {
            return Category ::get ();
        }
        
        public function save ( $request ): mixed {
            return Category ::create ( [
                                           'user_id'   => auth () -> user () -> id,
                                           'parent_id' => $request -> input ( 'parent-id' ),
                                           'icon'      => $request -> input ( 'icon' ),
                                           'title'     => $request -> input ( 'title' ),
                                           'slug'      => $this -> generate_slug ( $request -> input ( 'title' ) ),
                                           'image'     => ( new GeneralService() ) -> upload_image ( $request, './uploads/categories/' )
                                       ] );
        }
        
        public function edit ( $request, $category ): void {
            // dd( $request->all() , $category );
            $category -> user_id = auth () -> user () -> id;
            $category -> title   = $request -> input ( 'title' );
            $category -> parent_id =  $request -> input ( 'category-id' );
            $category -> icon =  $request -> input ( 'icon' );

           
            
            if ( $request -> hasFile ( 'image' ) )
                $category -> image = ( new GeneralService() ) -> upload_image ( $request, './uploads/categories/' );
            
            $category -> update ();
        }
        
        private function generate_slug ( $title ) {
            $slug = str ( $title ) -> slug ( '-' );
            $rows = Category ::where ( [ 'slug' => $slug ] ) -> count ();
            if ( $rows > 0 )
                return $slug . '-' . ( $rows + 1 );
            else
                return $slug;
        }
    }