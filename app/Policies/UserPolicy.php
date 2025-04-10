<?php

    namespace App\Policies;

    use App\Models\User;
    use Illuminate\Auth\Access\HandlesAuthorization;

    class UserPolicy {

        use HandlesAuthorization;
        
        public function viewDashboardMenu ( User $user ) {
            if ( in_array ( 'dashboard-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * Determine whether the user can view the model.
         * @param \App\Models\User $user
         * @param \App\Models\User $model
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */

        public function viewUsersMenu ( User $user ) {
            if ( in_array ( 'users-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * Determine whether the user can view the model.
         * @param \App\Models\User $user
         * @param \App\Models\User $model
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */

        public function viewAllUsers ( User $user ) {
            if ( in_array ( 'all-users-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * Determine whether the user can create models.
         * @param \App\Models\User $user
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */

        public function create ( User $user ) {
            if ( in_array ( 'add-users-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * Determine whether the user can edit models.
         * @param \App\Models\User $user
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */

        public function edit ( User $user ) {
            if ( in_array ( 'edit-users-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * Determine whether the user can update the model.
         * @param \App\Models\User $user
         * @param \App\Models\User $model
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */

        public function update ( User $user, User $model ) {
            if ( in_array ( 'edit-users-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * Determine whether the user can delete the model.
         * @param \App\Models\User $user
         * @param \App\Models\User $model
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */

        public function delete ( User $user, User $model ) {
            if ( in_array ( 'delete-users-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function status ( User $user, User $model ) {
            if ( in_array ( 'status-users-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * Determine whether the user can restore the model.
         * @param \App\Models\User $user
         * @param \App\Models\User $model
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */

        public function restore ( User $user, User $model ) {
            //
        }

        /**
         * --------------
         * Determine whether the user can permanently delete the model.
         * @param \App\Models\User $user
         * @param \App\Models\User $model
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */

        public function forceDelete ( User $user, User $model ) {
            //
        }

        /**
         * --------------
         * @param User $user
         * @return bool
         * view reporting menu
         * --------------
         */

        public function viewReportingMenu ( User $user ) {
            if ( in_array ( 'reporting-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function viewAccountsReportingMenu ( User $user ) {
            if ( in_array ( 'accounts-reporting-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * @param User $user
         * @return bool
         * view general reporting menu
         * --------------
         */

        public function viewGeneralSalesReport ( User $user ) {
            if ( in_array ( 'general-sales-report-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * @param User $user
         * @return bool
         * view general reporting menu
         * --------------
         */

        public function viewGeneralSalesReportAttributeWise ( User $user ) {
            if ( in_array ( 'general-sales-report-attribute-wise-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * @param User $user
         * @return bool
         * view general reporting menu
         * --------------
         */

        public function viewGeneralSalesReportProductWise ( User $user ) {
            if ( in_array ( 'general-sales-report-product-wise-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * @param User $user
         * @return bool
         * view general reporting menu
         * --------------
         */

        public function viewTrialBalanceSheet ( User $user ) {
            if ( in_array ( 'trial-balance-sheet-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * @param User $user
         * @return bool
         * view general reporting menu
         * --------------
         */

        public function viewStockValuationTPReport ( User $user ) {
            if ( in_array ( 'stock-valuation-tp-report-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * @param User $user
         * @return bool
         * view general reporting menu
         * --------------
         */

        public function viewStockValuationSaleReport ( User $user ) {
            if ( in_array ( 'stock-valuation-sale-report-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        public function viewStockStatementReport ( User $user ) {
            if ( in_array ( 'stock-statement-report-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * @param User $user
         * @return bool
         * view threshold report
         * --------------
         */

        public function viewThresholdReport ( User $user ) {
            if ( in_array ( 'threshold-report-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * @param User $user
         * @return bool
         * view profit report
         * --------------
         */

        public function viewProfitReport ( User $user ) {
            if ( in_array ( 'profit-report-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * @param User $user
         * @return bool
         * view customer payable report
         * --------------
         */

        public function customerPayableReport ( User $user ) {
            if ( in_array ( 'customers-payable-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * @param User $user
         * @return bool
         * view vendor payable report
         * --------------
         */

        public function vendorPayableReport ( User $user ) {
            if ( in_array ( 'vendors-payable-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * @param User $user
         * @return bool
         * attribute wise quantity report
         * --------------
         */

        public function attributeWiseQuantityReport ( User $user ) {
            if ( in_array ( 'attribute-wise-quantity-report-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function categoryWiseQuantityReport ( User $user ) {
            if ( in_array ( 'category-wise-quantity-report-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * @param User $user
         * @return bool
         * sales analysis report (products)
         * --------------
         */

        public function productSalesAnalysisReport ( User $user ) {
            if ( in_array ( 'product-sales-analysis-report-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * @param User $user
         * @return bool
         * sales analysis report (attributes)
         * --------------
         */

        public function attributeSalesAnalysisReport ( User $user ) {
            if ( in_array ( 'attribute-sales-analysis-report-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function profitAndLossReport ( User $user ) {
            if ( in_array ( 'profit-and-loss-report-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function customerReturnReport ( User $user ) {
            if ( in_array ( 'customer-return-report-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function vendorReturnReport ( User $user ) {
            if ( in_array ( 'vendor-return-report-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function supplierWiseReport ( User $user ) {
            if ( in_array ( 'supplier-wise-report-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function purchaseAnalysisReport ( User $user ) {
            if ( in_array ( 'purchase-analysis-report-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function viewAdjustmentsMenu ( User $user ) {
            if ( in_array ( 'adjustments-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function viewAllAdjustmentsIncrease ( User $user ) {
            if ( in_array ( 'all-adjustments-increase-menu-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function addAdjustmentsIncrease ( User $user ) {
            if ( in_array ( 'add-adjustments-increase-menu-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function editAdjustmentsIncrease ( User $user ) {
            if ( in_array ( 'edit-adjustments-increase-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function deleteAdjustmentsIncrease ( User $user ) {
            if ( in_array ( 'delete-adjustments-increase-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function viewAllAdjustmentsDecrease ( User $user ) {
            if ( in_array ( 'all-adjustments-decrease-menu-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function editAdjustmentsDecrease ( User $user ) {
            if ( in_array ( 'edit-adjustments-decrease-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function deleteAdjustmentsDecrease ( User $user ) {
            if ( in_array ( 'delete-adjustments-decrease-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function addAdjustmentsDecrease ( User $user ) {
            if ( in_array ( 'add-adjustments-decrease-menu-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function allDamageLoss ( User $user ) {
            if ( in_array ( 'all-damage-loss-menu-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function addDamageLoss ( User $user ) {
            if ( in_array ( 'add-damage-loss-menu-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function editDamageLoss ( User $user ) {
            if ( in_array ( 'edit-damage-loss-menu-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function deleteDamageLoss ( User $user ) {
            if ( in_array ( 'delete-damage-loss-menu-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function checkStock ( User $user ) {
            if ( in_array ( 'check-stock-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function bulkUpdatePrices ( User $user ) {
            if ( in_array ( 'bulk-update-prices-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function bulkUpdatePricesCategoryWise ( User $user ) {
            if ( in_array ( 'bulk-update-prices-category-wise-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        public function saleAnalysisReport ( User $user ) {
            if ( in_array ( 'sale-analysis-report-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function couponReport ( User $user ) {
            if ( in_array ( 'coupon-report-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function reviewedit ( User $user ) {
            if ( in_array ( 'review-edit-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function deletereview ( User $user ) {
            if ( in_array ( 'review-delete-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function approve_disapprove ( User $user ) {
            if ( in_array ( 'approve-disapprove-review-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function reviews_sidebar ( User $user ) {
            if ( in_array ( 'reviews-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        public function reviews_report_sidebar ( User $user ) {
            if ( in_array ( 'review-report-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
    }
