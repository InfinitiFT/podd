package com.podd.activityrestauarant;

import android.content.Context;
import android.content.Intent;
import android.net.Uri;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.GridLayoutManager;
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
import com.podd.adapter.BestRestaurantAdapter;
import com.podd.adapter.RestaurantsAdapter;
import com.podd.model.Restaurant;
import com.podd.retrofit.ApiClient;
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
    private String TAG=RestaurantDetailScreenActivity.class.getSimpleName();
    private List<String>restaurantList=new ArrayList<>();
    private String latitude,longitude,lat,longi;
    private String restaurantId;
    private String restaurantname;
    private String location;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_restaurant_detail_screen);
        context=RestaurantDetailScreenActivity.this;
        getIds();
        setListeners();
        latitude=getIntent().getStringExtra(AppConstant.LATITUDE);
        longitude=getIntent().getStringExtra(AppConstant.LONGITUDE);
        lat = CommonUtils.getPreferences(this,AppConstant.LATITUDE);
        longi = CommonUtils.getPreferences(this,AppConstant.LONGITUDE);
        restaurantId=getIntent().getStringExtra(AppConstant.RESTAURANTID);
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
        final JsonRequest jsonRequest = new JsonRequest();
        jsonRequest.latitude = latitude;
        jsonRequest.longitude = longitude;
        jsonRequest.restaurant_id = restaurantId;
        Log.e(TAG, "" + new Gson().toJsonTree(jsonRequest).toString().trim());
        Call<JsonResponse> call = ApiClient.getApiService().getRestaurantDetails(jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {
                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {
                    Log.e(TAG, "" + new Gson().toJsonTree(response.body().toString().trim()));
                    if (response.body().responseCode.equalsIgnoreCase("200")) {
                        if (response.body()!=null&&response.body().restaurant_images.size()>0) {

                            restaurantList.clear();
                            restaurantList.addAll(response.body().restaurant_images);
                            RestaurantsAdapter RestaurantsAdapter = new RestaurantsAdapter(context,restaurantList);
                            RecyclerView.LayoutManager mLayoutManager = new LinearLayoutManager(context,LinearLayoutManager.HORIZONTAL,false);
                            rvRestaurants.setLayoutManager(mLayoutManager);
                            rvRestaurants.setAdapter(RestaurantsAdapter);
                            tvDescriptionRestaraunt.setText(response.body().about_text);
                            tvNameRestaraunt.setText(response.body().restaurant_name);
                            restaurantname=response.body().restaurant_name;
                            tvLocation.setText(response.body().location);
                            tvDistance.setText(response.body().distance);
                            tvPriceRange.setText(response.body().price_range);
                            tvRestauarntName.setText(response.body().restaurant_name);
                            if(response.body().cuisine!=null&&response.body().cuisine.size()>0) {
                                tvCategory.setText(response.body().cuisine.get(0).name.trim());
                            }
                            else {
                                Toast.makeText(context, R.string.data_not_found, Toast.LENGTH_SHORT).show();
                            }

                        } else {
                            Toast.makeText(context, R.string.data_not_found, Toast.LENGTH_SHORT).show();
                        }
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
