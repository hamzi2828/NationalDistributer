<?php
    
    namespace App\Services;
    
    use App\Models\User;
    use Illuminate\Support\Facades\File;
    
    class GeneralService {
        
        public function date_formatter ( $date ): string {
            return date ( 'd-m-Y H:i:s', strtotime ( $date ) );
        }
        
        public function upload_image ( $request, $savePath = './uploads/', $file_name = 'image' ) {
            
            File ::ensureDirectoryExists ( $savePath, 0755, true );
            
            if ( $request -> hasFile ( $file_name ) ) {
                $filenameWithExt = $request -> file ( $file_name ) -> getClientOriginalName ();
                $filename        = pathinfo ( $filenameWithExt, PATHINFO_FILENAME );
                $extension       = $request -> file ( $file_name ) -> getClientOriginalExtension ();
                $fileNameToStore = $filename . '-' . time () . '.' . $extension;
                return $request -> file ( $file_name ) -> storeAs ( $savePath, $fileNameToStore );
            }
        }
        
        function buildTree ( array $elements, $parentId = 0 ): array {
            $branch = array ();
            
            foreach ( $elements as $element ) {
                if ( $element[ 'parent_id' ] == $parentId ) {
                    $children = $this -> buildTree ( $elements, $element[ 'id' ] );
                    if ( $children ) {
                        $element[ 'children' ] = $children;
                    }
                    $branch[] = $element;
                }
            }
            
            return $branch;
        }
        
        public function convertToOptions ( $array = array (), $disabled = true, $indentation = 0, $selected_id = 0 ): string {
            
            $item     = '';
            $indent   = str_repeat ( '&nbsp;', $indentation * 5 );
            
            if ( count ( $array ) > 0 ) {
                foreach ( $array as $key => $value ) {
                    
                    if ( array_key_exists ( 'children', $value ) ) {
                        
                        if ( count ( $value[ 'children' ] ) > 0 && $disabled )
                            $disabled = 'disabled="disabled"';
                        else
                            $disabled = '';
                        
                        $selected = $value[ 'id' ] == $selected_id ? 'selected="selected"' : '';
                        $item     .= '<option value="' . $value[ 'id' ] . '" ' . $selected . $disabled . '><strong>' . $indent . $value[ 'title' ] . '</strong></option>';
                        
                        if ( count ( $value[ 'children' ] ) > 0 ) {
                            $item .= $this -> convertToOptions ( $value[ 'children' ], $disabled, $indentation + 1, $selected_id );
                        }
                    }
                    else {
                        $selected = $value[ 'id' ] == $selected_id ? 'selected="selected"' : '';
                        $item     .= $indent . '<option value="' . $value[ 'id' ] . '" ' . $selected . '>' . $indent . $value[ 'title' ] . '</option>';
                    }
                }
            }
            
            return $item;
        }
    }