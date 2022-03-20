<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('CWR_Part_Number');
            $table->string('Manufacturer_Part_Number');
            $table->string('UPC_Code');
            $table->string('Quantity_Available_to_Ship_(Combined)');
            $table->string('Quantity_Available_to_Ship_(NJ)');
            $table->string('Quantity_Available_to_Ship_(FL)');
            $table->string('Next_Shipment_Date_(Combined)');
            $table->string('Next_Shipment_Date_(NJ)');
            $table->string('Next_Shipment_Date_(FL)');
            $table->string('Your_Cost');
            $table->string('List_Price');
            $table->string('MAP_Price');
            $table->string('MRP_Price');
            $table->string('Uppercase_Title');
            $table->string('Title');
            $table->string('Full_Description');
            $table->string('Category_ID');
            $table->string('Category_Name');
            $table->string('Manufacturer_Name');
            $table->string('Shipping_Weight');
            $table->string('Box_Height');
            $table->string('Box_Length');
            $table->string('Box_Width');
            $table->string('List_of_Accessories_by_SKU');
            $table->string('List_of_Accessories_by_MFG#');
            $table->string('Quick_Specs');
            $table->string('Image_(300x300)_Url');
            $table->string('Image_(1000x1000)_Url');
            $table->string('Special_Order');
            $table->string('Drop_Ships_Direct_From_Vendor');
            $table->string('Hazardous_Materials');
            $table->string('Truck_Freight');
            $table->string('Exportable');
            $table->string('First_Class_Mail');
            $table->string('Oversized');
            $table->string('Remanufactured');
            $table->string('Closeout');
            $table->string('Harmonization_Code');
            $table->string('Country_Of_Origin');
            $table->string('Sale');
            $table->string('Original_Price_(If_on_Sale/Closeout)');
            $table->string('Sale_Start_Date');
            $table->string('Sale_End_Date');
            $table->string('Rebate');
            $table->string('Rebate_Description');
            $table->string('Rebate_Start_Date');
            $table->string('Rebate_End_Date');
            $table->string('Google_Merchant_Category');
            $table->string('Quick_Guide_Literature_(pdf)_Url');
            $table->string('Owners_Manual_(pdf)_Url');
            $table->string('Brochure_Literature_(pdf)_Url');
            $table->string('Installation_Guide_(pdf)_Url');
            $table->string('Video_Urls');
            $table->string('Prop_65');
            $table->string('Prop_65_Description');
            $table->string('Free_Shipping');
            $table->string('Free_Shipping_End_Date');
            $table->string('Returnable');
            $table->string('Image_Additional_(1000x1000)_Urls');
            $table->string('Case_Qty_(NJ)');
            $table->string('Case_Qty_(FL)');
            $table->string('3rd_Party_Marketplaces');           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
