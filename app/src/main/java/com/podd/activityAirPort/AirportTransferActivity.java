package com.podd.activityAirPort;

import android.content.Context;
import android.content.Intent;
import android.graphics.Typeface;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.View;
import android.widget.TextView;

import com.podd.R;
import com.podd.adapter.AirprotHeaderImageAdapter;
import com.podd.model.HomeItemsModel;
import com.podd.utils.SetTimerClass;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by Raj Kumar on 3/7/2017
 * for Mobiloitte
 */

public class AirportTransferActivity extends AppCompatActivity implements View.OnClickListener {
    private Context mContext=AirportTransferActivity.this;
    private TextView tvTravelBag,tvTravelBagMsg,tvBagCheck,tvBagCheckMsg,tvCost,tvCostMsg,tvDiscountMsg,tvGetYourQuots;
    private SetTimerClass setTimerClass;
    private TextView tvHeader;
    private RecyclerView rvHeaderImage;
    private AirprotHeaderImageAdapter airprotHeaderImageAdapter;
    private List<HomeItemsModel> homeItemsModelList = new ArrayList<>();
    private  int[] img = new int[]{R.mipmap.image2, R.mipmap.image3, R.mipmap.image4, R.mipmap.image1,R.mipmap.image2, R.mipmap.image3, R.mipmap.image4, R.mipmap.image1,R.mipmap.image2, R.mipmap.image3, R.mipmap.image4, R.mipmap.image1};

    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_airport_transfer);
        getIds();
        setFont();
        setListeners();
        setRecycler();
        setTimerClass = (SetTimerClass)getApplication();
        for (int i = 0; i < img.length; i++) {
            HomeItemsModel hotelItemModel = new HomeItemsModel();
            hotelItemModel.setImage(img[i]);
            homeItemsModelList.add(hotelItemModel);

        }

    }  private void setRecycler() {
        airprotHeaderImageAdapter = new AirprotHeaderImageAdapter(mContext,homeItemsModelList);
        RecyclerView.LayoutManager mLayoutManager = new LinearLayoutManager(mContext,LinearLayoutManager.HORIZONTAL,false);
        rvHeaderImage.setLayoutManager(mLayoutManager);
        rvHeaderImage.setAdapter(airprotHeaderImageAdapter);
    }

    private void getIds() {

        tvHeader = (TextView) findViewById(R.id.tvHeader);
        tvTravelBag = (TextView) findViewById(R.id.tvTravelBag);
        tvTravelBagMsg = (TextView) findViewById(R.id.tvTravelBagMsg);
        //   tvCityName = (TextView) findViewById(R.id.tvCityName);
        tvBagCheck = (TextView) findViewById(R.id.tvBagCheck);
        tvBagCheckMsg = (TextView) findViewById(R.id.tvBagCheckMsg);
        tvCost = (TextView) findViewById(R.id.tvCost);
        tvCostMsg = (TextView) findViewById(R.id.tvCostMsg);
        tvDiscountMsg = (TextView) findViewById(R.id.tvDiscountMsg);
        tvGetYourQuots = (TextView) findViewById(R.id.tvGetYourQuots);
        rvHeaderImage = (RecyclerView) findViewById(R.id.rvHeaderImage);


    }
    private void setFont() {
        Typeface typeface = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Regular.ttf");
        Typeface typefaceBold = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Bold.ttf");

        tvHeader.setTypeface(typefaceBold);
        tvGetYourQuots.setTypeface(typefaceBold);
        tvTravelBag.setTypeface(typeface);
        tvTravelBagMsg.setTypeface(typeface);
        tvBagCheck.setTypeface(typeface);
        tvBagCheckMsg.setTypeface(typeface);
        tvCost.setTypeface(typeface);
        tvCostMsg.setTypeface(typeface);
        tvDiscountMsg.setTypeface(typeface);


    }
    @Override
    protected void onResume() {
        super.onResume();
        setTimerClass.setTimer(this, true);
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        setTimerClass.setTimer(this, true);
    }

    @Override
    public void onUserInteraction() {
        super.onUserInteraction();
        setTimerClass.setTimer(this, false);
    }
    private void setListeners() {
        tvGetYourQuots.setOnClickListener(this);
    }
    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.tvGetYourQuots:
               startActivity(new Intent(mContext,AirportDetailActivity.class));
                break;

        }

    }
    /*private void getRestaurantDetailApi() {
        CommonUtils.showProgressDialog(mContext);
        ApiInterface apiServices = ApiClient.getClient(this).create(ApiInterface.class);
        final JsonRequest jsonRequest = new JsonRequest();
        jsonRequest.latitude = latitude;
        jsonRequest.longitude = longitude;
        jsonRequest.restaurant_id = restaurantId;
        jsonRequest.deliver_food = "1";
        Call<JsonResponse> call = apiServices.getRestaurantDetails(CommonUtils.getPreferences(this, AppConstant.AppToken),jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {
                CommonUtils.disMissProgressDialog(mContext);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {
                    if (response.body().responseCode.equalsIgnoreCase("200")) {
                        restaurantList.clear();
                        if(response.body().restaurant_images!=null) {
                            restaurantList.addAll(response.body().restaurant_images);
                            RestaurantsAdapter restaurantsAdapter = new RestaurantsAdapter(context, restaurantList);
                            RecyclerView.LayoutManager mLayoutManager = new LinearLayoutManager(context, LinearLayoutManager.HORIZONTAL, false);
                            rvRestaurants.setLayoutManager(mLayoutManager);
                            rvRestaurants.setAdapter(restaurantsAdapter);
                        }
                        else {
                            Toast.makeText(context,R.string.data_not_found,Toast.LENGTH_SHORT).show();

                        }
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

                        if(response.body().restaurant_menu!=null&&response.body().restaurant_menu.size()>0){
                            restaurantMenu.clear();
                            restaurantMenu.addAll(response.body().restaurant_menu);
                        }

                        if(response.body().price_range!=null&&response.body().price_range.length()>0) {
                            String priceRange = response.body().price_range;
                            String[] splited = priceRange.split("-");
                            String split_one = splited[0];
                            String split_second = splited[1];
                            tvPriceRange.setText("£ " + split_one + " - " + "£ " + split_second);
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

                        if(response.body().cuisine!=null && response.body().cuisine.size()>0) {
                            StringBuilder cuisineName= new StringBuilder();
                            String delim=", ";
                            for (int i = 0; i < response.body().cuisine.size(); i++) {
                                cuisineName.append(response.body().cuisine.get(i).cuisine_name);
                                if(i!=response.body().cuisine.size()-1)
                                    cuisineName.append(delim);
                            }
                            tvCuisine.setText(cuisineName);
                        }
                        else {
                            Toast.makeText(context, R.string.data_not_found, Toast.LENGTH_SHORT).show();
                        }

                        if(response.body().dietary!=null&&response.body().dietary.size()>0) {
                            StringBuilder dietaryName= new StringBuilder();
                            String delim=", ";
                            for (int i = 0; i < response.body().dietary.size(); i++) {
                                dietaryName.append(response.body().dietary.get(i).dietary_name);
                                if(i!=response.body().dietary.size()-1)
                                    dietaryName.append(delim);
                            }
                            tvDietary.setText(dietaryName);

                        }
                        else {
                            Toast.makeText(context, R.string.data_not_found, Toast.LENGTH_SHORT).show();
                        }

                        if(response.body().ambience!=null&&response.body().ambience.size()>0) {
                            StringBuilder ambienceName= new StringBuilder();
                            String delim=", ";
                            for (int i = 0; i < response.body().ambience.size(); i++) {
                                ambienceName.append(response.body().ambience.get(i).ambience_name);
                                if(i!=response.body().ambience.size()-1)
                                    ambienceName.append(delim);
                            }
                            tvAmbience.setText(ambienceName);
                        }
                        else {
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
    }*/
}
