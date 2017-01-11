package com.podd.activityRestaurant;

import android.content.Context;
import android.content.Intent;
import android.net.Uri;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;
import com.google.gson.Gson;
import com.podd.R;
import com.podd.adapter.RestaurantsAdapter;
import com.podd.retrofit.ApiClient;
import com.podd.retrofit.ApiInterface;
import com.podd.utils.AppConstant;
import com.podd.utils.CommonUtils;
import com.podd.webservices.JsonRequest;
import com.podd.webservices.JsonResponse;
import java.io.Serializable;
import java.util.ArrayList;
import java.util.List;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;


/**
 * The type Restaurant detail screen activity.
 */
public class RestaurantDetailScreenActivity extends AppCompatActivity implements View.OnClickListener {

    private TextView tvRestauarntName;
    private TextView tvNameRestaraunt;
    private TextView tvCategory;
    private TextView tvPriceRange;
    private TextView tvLocation;
    private TextView tvDistance;
    private TextView tvBookNow;
    private TextView tvAboutRestaurant;
    private TextView tvDescriptionRestaraunt;
    private TextView tvViewMenu;
    private TextView tvViewInMap;
    private LinearLayout llInner;
    private LinearLayout llButtons;
    private LinearLayout llDistance;
    private LinearLayout llLocation;
    private LinearLayout llPriceRange;
    private LinearLayout llCategory;
    private LinearLayout llRestaurantName;
    private RecyclerView rvRestaurants;
    private Context context;
    private Intent intent;
    private final String TAG=RestaurantDetailScreenActivity.class.getSimpleName();
    private final List<String>restaurantList=new ArrayList<>();
    private String latitude,longitude,lat,longi;
    private String restaurantId;
    private String restaurantname;
    private String location;
    private final List<String> categories=new ArrayList<>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_restaurant_detail_screen);
        context=RestaurantDetailScreenActivity.this;
        getIds();
        setListeners();
        if(getIntent()!=null){
            latitude=getIntent().getStringExtra(AppConstant.LATITUDE);
            longitude=getIntent().getStringExtra(AppConstant.LONGITUDE);
            restaurantId=getIntent().getStringExtra(AppConstant.RESTAURANTID);
            location=getIntent().getStringExtra(AppConstant.LOCATION);
        }

        lat = CommonUtils.getPreferences(this,AppConstant.LATITUDE);
        longi = CommonUtils.getPreferences(this,AppConstant.LONGITUDE);

        getRestaurantDetailApi();
    }

    private void getIds() {
        tvRestauarntName= (TextView) findViewById(R.id.tvRestauarntName);
        tvNameRestaraunt= (TextView) findViewById(R.id.tvNameRestaraunt);
        tvCategory= (TextView) findViewById(R.id.tvCategory);
        tvPriceRange= (TextView) findViewById(R.id.tvPriceRange);
        tvLocation= (TextView) findViewById(R.id.tvLocation);
        location=tvLocation.getText().toString().trim();
        tvDistance= (TextView) findViewById(R.id.tvDistance);
        tvBookNow= (TextView) findViewById(R.id.tvBookNow);
        tvAboutRestaurant= (TextView) findViewById(R.id.tvAboutRestaurant);
        tvDescriptionRestaraunt= (TextView) findViewById(R.id.tvDescriptionRestaraunt);
        tvViewMenu= (TextView) findViewById(R.id.tvViewMenu);
        tvViewInMap= (TextView) findViewById(R.id.tvViewInMap);
        llInner= (LinearLayout) findViewById(R.id.llInner);
        llButtons= (LinearLayout) findViewById(R.id.llButtons);
        llDistance= (LinearLayout) findViewById(R.id.llDistance);
        llLocation= (LinearLayout) findViewById(R.id.llLocation);
        llPriceRange= (LinearLayout) findViewById(R.id.llPriceRange);
        llCategory= (LinearLayout) findViewById(R.id.llCategory);
        llRestaurantName= (LinearLayout) findViewById(R.id.llRestaurantName);
        rvRestaurants= (RecyclerView) findViewById(R.id.rvRestaurants);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        if (getSupportActionBar() != null) {
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
            getSupportActionBar().setDisplayShowHomeEnabled(true);
            getSupportActionBar().setTitle("");
        }
        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onBackPressed();
            }
        });
    }

    private void setListeners() {
        tvBookNow.setOnClickListener(this);
        tvViewMenu.setOnClickListener(this);
        tvViewInMap.setOnClickListener(this);

    }

    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.tvBookNow:
                intent=new Intent(context,RestaurantBookingDetailsActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                intent.putExtra(AppConstant.RESTAURANTIMAGES, (Serializable) restaurantList);
                intent.putExtra(AppConstant.RESTAURANTNAME,restaurantname);
                intent.putExtra(AppConstant.RESTAURANTID,restaurantId);
                intent.putExtra(AppConstant.LOCATION,location);
                startActivity(intent);
                break;
            case R.id.tvViewMenu:
                intent=new Intent(context,ViewMenuActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                intent.putExtra(AppConstant.RESTAURANTIMAGES, (Serializable) restaurantList);
                intent.putExtra(AppConstant.RESTAURANTNAME,restaurantname);
                intent.putExtra(AppConstant.RESTAURANTID,restaurantId);
                intent.putExtra(AppConstant.LOCATION,location);
                startActivity(intent);
                break;

            case R.id.tvViewInMap:

                String uriString = "http://maps.google.com/maps?saddr="+lat+","+longi+"&daddr="+latitude+","+longitude;
                Intent intent = new Intent(android.content.Intent.ACTION_VIEW,
                        Uri.parse(uriString));
                startActivity(intent);

                break;
        }
    }


    private void getRestaurantDetailApi() {
        CommonUtils.showProgressDialog(context);
        ApiInterface apiServices = ApiClient.getClient(this).create(ApiInterface.class);
        final JsonRequest jsonRequest = new JsonRequest();
        jsonRequest.latitude = latitude;
        jsonRequest.longitude = longitude;
        jsonRequest.restaurant_id = restaurantId;
        Call<JsonResponse> call = apiServices.getRestaurantDetails(CommonUtils.getPreferences(this,AppConstant.AppToken),jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {
                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {

                    if (response.body().responseCode.equalsIgnoreCase("200")) {
                        restaurantList.clear();
                        restaurantList.addAll(response.body().restaurant_images);
                        RestaurantsAdapter RestaurantsAdapter = new RestaurantsAdapter(context,restaurantList);
                        RecyclerView.LayoutManager mLayoutManager = new LinearLayoutManager(context,LinearLayoutManager.HORIZONTAL,false);
                        rvRestaurants.setLayoutManager(mLayoutManager);
                        rvRestaurants.setAdapter(RestaurantsAdapter);
                        if(response.body().about_text!=null) {
                            tvDescriptionRestaraunt.setText(response.body().about_text);
                        }
                        else{
                            tvDescriptionRestaraunt.setText("");
                        }
                        if(response.body().restaurant_name!=null) {
                            tvNameRestaraunt.setText(response.body().restaurant_name);
                            restaurantname=response.body().restaurant_name;
                        }
                        else{
                            tvNameRestaraunt.setText("");
                            restaurantname=tvNameRestaraunt.getText().toString().trim();
                        }
                        if (response.body().location!=null) {
                            tvLocation.setText(response.body().location);
                        }
                        else {
                            tvLocation.setText("");
                        }
                        if (response.body().distance!=null) {
                            tvDistance.setText(response.body().distance);
                        }
                        else {
                            tvDistance.setText("");
                        }
                        if(response.body().price_range!=null&&response.body().price_range.length()>0) {
                            String priceRange = response.body().price_range;
                            String[] splited = priceRange.split("-");

                            String split_one = splited[0];
                            String split_second = splited[1];
                            tvPriceRange.setText("$ " + split_one + " - " + "$ " + split_second);
                        }
                        else {
                            tvPriceRange.setText(response.body().price_range);
                        }

                        if(response.body().restaurant_name!=null) {
                            tvRestauarntName.setText(response.body().restaurant_name);
                        }
                        else {
                            tvRestauarntName.setText("");
                        }

                        if(response.body().cuisine!=null&&response.body().cuisine.size()>0) {
                            for (int i = 0; i <response.body().cuisine.size() ; i++) {
                                if(response.body().cuisine.get(i).name!=null && !response.body().cuisine.get(i).name.equalsIgnoreCase("") )

                                    categories.add(response.body().cuisine.get(i).name);
                            }
                        }
                        else {
                            Toast.makeText(context, R.string.data_not_found, Toast.LENGTH_SHORT).show();
                        }

                        if(response.body().dietary!=null&&response.body().dietary.size()>0) {
                            for (int i = 0; i <response.body().dietary.size() ; i++) {
                                if(response.body().dietary.get(i).name!=null && !response.body().dietary.get(i).name.equalsIgnoreCase("") )

                                    categories.add(response.body().dietary.get(i).name);
                            }
                        }
                        else {
                            Toast.makeText(context, R.string.data_not_found, Toast.LENGTH_SHORT).show();
                        }

                        if(response.body().ambience!=null&&response.body().ambience.size()>0) {
                            for (int i = 0; i <response.body().ambience.size() ; i++) {
                                if(response.body().ambience.get(i).name!=null && !response.body().ambience.get(i).name.equalsIgnoreCase("") )
                                    categories.add(response.body().ambience.get(i).name);
                            }
                        }
                        else {
                            Toast.makeText(context, R.string.data_not_found, Toast.LENGTH_SHORT).show();
                        }
                        String s1="";
                        for (int i = 0; i <categories.size() ; i++) {

                            s1 = categories.get(i) + ", " + s1;
                        }
                        tvCategory.setText(s1);
                    } else {
                        Toast.makeText(context, response.body().responseMessage, Toast.LENGTH_SHORT).show();
                    }
                } else {
                    Toast.makeText(context, R.string.server_not_responding, Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onFailure(Call<JsonResponse> call, Throwable t) {
                CommonUtils.disMissProgressDialog(context);
                Log.e(TAG, t.toString());

            }
        });


    }


}
