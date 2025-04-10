<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\ProductUserReviewFormRequest;
    use App\Models\ProductUserReview;
    use App\Models\Product;

    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
     
    class ProductUserReviewController extends Controller {
        
        public function index (): View {
            $data[ 'title' ]   = 'Products Reviews';
            $data[ 'reviews' ] = ProductUserReview ::with ( [ 'product', 'user' ] ) -> latest () -> get ();

            // dd( $data[ 'reviews' ]);
            return view ( 'products.reviews', $data );
        }
        
        public function create () {
            //
        }
        
        public function store ( ProductUserReviewFormRequest $request ) {
            //
        }
        
        public function edit ( ProductUserReview $review ) {
            //
        }
        
        public function update ( ProductUserReviewFormRequest $request, ProductUserReview $review ) {
            try {
                $this->authorize('approve_disapprove', User::class);
                DB ::beginTransaction ();
                $review -> active = $review -> active == '0' ? '1' : '0';
                $review -> update ();
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Review has been updated.' );
                
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( ProductUserReview $review ) {
            try {
                $this->authorize('deletereview', User::class);

                DB ::beginTransaction ();
                $review -> delete ();
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Review has been deleted.' );
                
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

        public function edit_review(Request $request, $id)
        {

            $this->authorize('reviewedit', User::class);

            $request->validate([
               'rating' => 'required|integer|min:1|max:5',
                'review' => 'required|string',
            ]);
        
            // Find the review
            $review = ProductUserReview::findOrFail($id);
        
            // Update review
            $review->update([
                'rating' => $request->input('rating'),
                'review' => $request->input('review'),

            ]);
        
            // Redirect back with success message
            return redirect()->back()->with('success', 'Review updated successfully.');
        }
        


        public function reviews_report()
        {
            $data['title'] = 'Products Reviews Report';
            
            // Fetch reviews with related product and user
            $data['reviews'] = ProductUserReview::with(['product', 'user'])
                ->where('active', '1')
                ->latest()
                ->get();
            
            // Fetch all products
            // $data['products'] = Product::all();

            $data['products'] = Product::whereHas('reviews', function ($query) {
                $query->where('active', '1');
            })->get();
        
            
            
            return view('products.reviews-report', $data);
        }

        public function review_search_report(Request $request)
        {
        //   dd($request->all());
            // Validate the request
            $request->validate([
                'product-id' => 'nullable|exists:products,id', // Corrected 'proudct' to 'products'
                'start-date' => 'nullable|date',
                'end-date' => 'nullable|date|after_or_equal:start-date',
                'rating' => 'nullable|array',
                'rating.*' => 'integer|between:1,5', // Ensure rating values are integers between 1 and 5
            ]);
        
            // Get search parameters
            $productId = $request->input('product-id');
            $startDate = $request->input('start-date');
            $endDate = $request->input('end-date');
            $ratings = $request->input('rating', []); // Default to empty array if not provided
        
            $data['title'] = 'Products Reviews Report';
            
            // Fetch reviews with related product and user
            $query = ProductUserReview::with(['product', 'user'])
                ->where('active', '1');
        
            // Apply filters based on search parameters
            if ($productId) {
                $query->where('product_id', $productId);
            }
            if ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            }
            if ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            }
            if (!empty($ratings)) {
                $query->whereIn('rating', $ratings);
            }
        
            $data['reviews'] = $query->latest()->get();
            
            // Fetch all products
            $data['products'] = Product::all();
        
            return view('products.reviews-report', $data);
        }
        

        
        

    }
