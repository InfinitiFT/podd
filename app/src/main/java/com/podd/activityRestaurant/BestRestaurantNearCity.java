package com.podd.activityRestaurant;

import android.content.Context;
import android.graphics.Typeface;
import android.location.Location;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;
import com.podd.R;
import com.podd.adapter.BestRestaurantAdapter;
import com.podd.adapter.CuisineTypeRestaurantAdapter;
import com.podd.location.LocationResult;
import com.podd.location.LocationTracker;
import com.podd.model.Cuisine;
import com.podd.model.Restaurant;
import com.podd.retrofit.ApiClient;
import com.podd.retrofit.ApiInterface;
import com.podd.utils.AppConstant;
import com.podd.utils.CommonUtils;
import com.podd.utils.Logger;
import com.podd.utils.SetTimerClass;
import com.podd.webservices.JsonRequest;
import com.podd.webservices.JsonResponse;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;


@SuppressWarnings("ALL")
public class BestRestaurantNearCity extends AppCompatActivity implements View.OnClickListener, SearchableListDialog.SearchableItem ,SearchableLocationListDialog.SearchableItem{

    private RecyclerView rvRestaurants;
    private Context context;
    private BestRestaurantAdapter bestRestaurantAdapter;
    private TextView tvBusiness,tvMealType, tvCuisineType,tvLocationType,tvDietaryType,tvCityName,tvNearbyRestaurant;
    private TextView tvLocationName,tvSearchBy,tvLocation,tvDietary,tvShowing,tvVenueBy;
    private TextView tvNoOfRestaurants,tvCuisine,tvMeal,tvAmbience, tvDeliveredtoYou;
    private LinearLayout llLocation,llDietary, llCuisine, llMeal,llAmbience,llDeliveredToYou,llCurrentloc,llVenues;
    private double currentLat/*=28.5223*/;
    private double currentLong/*=77.2849*/;
    private List<Cuisine> cuisineList = new ArrayList<>();
    private List<Restaurant> restaurantList = new ArrayList<>();
    private List<String> location = new ArrayList<>();
    private String TAG = BestRestaurantNearCity.class.getSimpleName();
    private int pageNo = 1;
    private CuisineTypeRestaurantAdapter cuisineTypeRestaurantAdapter;
    private ArrayAdapter adapterLocation;
    private SearchableListDialog _searchableListDialog;
    private SearchableLocationListDialog searchableListDialog;
    private List<String> categories;
    private String selectedItem = "",cuisineId,locationId,mealId,dietaryId,ambienceId,restaurantlistSize;
    private GridLayoutManager gridLayoutManager;
    private EndlessScrollListener scrollListener;
    private boolean isRestaurant = false;
    private int pageSize = 10;
    private SetTimerClass setTimerClass;
    private String searched_item_name;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_best_restaurant_near_city);
        context = BestRestaurantNearCity.this;
        getIds();

        setListeners();
        setRecycle();
        fetchLocation();
        /*if (CommonUtils.isNetworkConnected(BestRestaurantNearCity.this)) {
            getAddressFromPlaceApi(String.valueOf(currentLat), String.valueOf(currentLong));
        } else {
            Toast.makeText(BestRestaurantNearCity.this, getString(R.string.server_not_responding), Toast.LENGTH_SHORT).show();
        }*/
        setFont();
        tvLocationName.setSelected(true);
        setTimerClass = (SetTimerClass)getApplication();

        try {
            scrollListener = new EndlessScrollListener(gridLayoutManager) {
                @Override
                public void onLoadMore(int page, int totalItemsCount, RecyclerView view) {
                    // Triggered only when new data needs to be appended to the list
                    // Add whatever code is needed to append new items to the bottom of the list

                    if (!isRestaurant) {
                        if (restaurantList.size() % pageSize == 0)
                            getRestaurantListApi(currentLat, currentLong, pageNo);
                          //  isRestaurant=false;
                    } else {
                       // pageNo=1;
                        if (restaurantList.size() % pageSize == 0)
                            callsearchedTextApi(pageNo,searched_item_name);
                    }
                }
            };
            // Adds the scroll listener to RecyclerView
            rvRestaurants.addOnScrollListener(scrollListener);
        } catch (Exception exc) {
            exc.printStackTrace();
        }


    }

    private void setFont() {
        Typeface typeface = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Regular.ttf");
        tvSearchBy.setTypeface(typeface);
        tvShowing.setTypeface(typeface);
        tvNoOfRestaurants.setTypeface(typeface);
        tvVenueBy.setTypeface(typeface);
        tvLocationName.setTypeface(typeface);
        tvLocation.setTypeface(typeface);
        tvLocationType.setTypeface(typeface);
        tvDietary.setTypeface(typeface);
        tvDietaryType.setTypeface(typeface);
        tvMeal.setTypeface(typeface);
        tvMealType.setTypeface(typeface);
        tvCuisine.setTypeface(typeface);
        tvCuisineType.setTypeface(typeface);
        tvAmbience.setTypeface(typeface);
        tvBusiness.setTypeface(typeface);

    }

    private void setRecycle() {
        gridLayoutManager = new GridLayoutManager(context, 2, LinearLayoutManager.HORIZONTAL, false);
        rvRestaurants.setLayoutManager(gridLayoutManager);
        bestRestaurantAdapter = new BestRestaurantAdapter(context, restaurantList);
        rvRestaurants.setAdapter(bestRestaurantAdapter);
    }

    private void setListeners() {
        llDeliveredToYou.setOnClickListener(this);
        llAmbience.setOnClickListener(this);
        llMeal.setOnClickListener(this);
        llCuisine.setOnClickListener(this);
        llDietary.setOnClickListener(this);
        llLocation.setOnClickListener(this);
    }

    private void getIds() {
        rvRestaurants = (RecyclerView) findViewById(R.id.rvRestaurants);
        llDeliveredToYou = (LinearLayout) findViewById(R.id.llDeliveredToYou);
        llAmbience = (LinearLayout) findViewById(R.id.llAmbience);
        llMeal = (LinearLayout) findViewById(R.id.llMeal);
        llCuisine = (LinearLayout) findViewById(R.id.llCuisine);
        llDietary = (LinearLayout) findViewById(R.id.llDietary);
        llLocation = (LinearLayout) findViewById(R.id.llLocation);
      //  tvNearbyRestaurant = (TextView) findViewById(R.id.tvNearbyRestaurant);
        tvVenueBy = (TextView) findViewById(R.id.tvVenueBy);
        tvShowing = (TextView) findViewById(R.id.tvShowing);
     //   tvCityName = (TextView) findViewById(R.id.tvCityName);
        tvSearchBy = (TextView) findViewById(R.id.tvSearchBy);
        tvDietaryType = (TextView) findViewById(R.id.tvDietaryType);
        tvLocation = (TextView) findViewById(R.id.tvLocation);
        tvLocationType = (TextView) findViewById(R.id.tvLocationType);
        tvDietary = (TextView) findViewById(R.id.tvDietary);
        tvCuisine = (TextView) findViewById(R.id.tvCuisine);
        tvCuisineType = (TextView) findViewById(R.id.tvCuisineType);
        tvMeal = (TextView) findViewById(R.id.tvMeal);
        tvMealType = (TextView) findViewById(R.id.tvMealType);
        tvAmbience = (TextView) findViewById(R.id.tvAmbience);
        tvBusiness = (TextView) findViewById(R.id.tvBusiness);
        tvDeliveredtoYou = (TextView) findViewById(R.id.tvDeliveredToYou);
        tvLocationName= (TextView) findViewById(R.id.tvLocationName);
        tvNoOfRestaurants= (TextView) findViewById(R.id.tvNoOfRestaurants);
       // llCurrentloc= (LinearLayout) findViewById(R.id.llCurrentloc);
        llVenues= (LinearLayout) findViewById(R.id.llVenues);
    }

    private void fetchLocation() {
        new LocationTracker(context, new LocationResult() {
            @Override
            public void gotLocation(Location location) {
                currentLat = location.getLatitude();
                currentLong = location.getLongitude();
                if (CommonUtils.isNetworkConnected(BestRestaurantNearCity.this)) {
                    getAddressFromPlaceApi(String.valueOf(currentLat), String.valueOf(currentLong));
                } else {
                    Toast.makeText(BestRestaurantNearCity.this, getString(R.string.server_not_responding), Toast.LENGTH_SHORT).show();
                }

                CommonUtils.savePreferencesString(BestRestaurantNearCity.this, AppConstant.LATITUDE, String.valueOf(currentLat));
                CommonUtils.savePreferencesString(BestRestaurantNearCity.this, AppConstant.LONGITUDE, String.valueOf(currentLong));
            }
        }).onUpdateLocation();
    }

    private void getAddressFromPlaceApi(String currLat, String currLong) {
        CommonUtils.showProgressDialog(context);
        ApiInterface apiServices = ApiClient.getClient(this).create(ApiInterface.class);
        String latLong = currLat + "," + currLong;
        Call<JsonResponse> call = apiServices.getPlaceApi(latLong);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {
                CommonUtils.disMissProgressDialog(context);
                /*tvCityName.setText(response.body().results.get(0).formatted_address);*/
                getRestaurantListApi(currentLat, currentLong, pageNo);
                llVenues.setVisibility(View.VISIBLE);
                tvLocationName.setText(response.body().results.get(0).formatted_address);
                Logger.addRecordToLog("Response " + response);
            }

            @Override
            public void onFailure(Call<JsonResponse> call, Throwable t) {
                CommonUtils.disMissProgressDialog(context);
                Logger.addRecordToLog("Exception :" + t.getMessage());
                CommonUtils.disMissProgressDialog(context);
                Log.e(TAG, t.toString());
            }
        });
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()) {
            case R.id.llAmbience:
                getAmbienceRestaurantListApi();
                llVenues.setVisibility(View.VISIBLE);
                break;
            case R.id.llLocation:
                llVenues.setVisibility(View.VISIBLE);
                getLocationRestaurantListApi();
                break;
            case R.id.llDietary:
                getDietaryRestaurantListApi();
                llVenues.setVisibility(View.VISIBLE);
                break;
            case R.id.llCuisine:
                getCuisineRestaurantListApi();
                llVenues.setVisibility(View.VISIBLE);
                break;
            case R.id.llMeal:
                getMealRestaurantListApi();
                llVenues.setVisibility(View.VISIBLE);
                break;
            case R.id.llDeliveredToYou:
                llVenues.setVisibility(View.VISIBLE);
                break;

        }
    }


    /******************************
     * Restaurant List Api
     ******************************/

    private void getRestaurantListApi(final double currentLat, double currentLong, int pageNumber) {
        CommonUtils.showProgressDialog(context);
        ApiInterface apiServices = ApiClient.getClient(this).create(ApiInterface.class);
        final JsonRequest jsonRequest = new JsonRequest();
        jsonRequest.latitude = String.valueOf(currentLat);
        jsonRequest.longitude = String.valueOf(currentLong);
        jsonRequest.page_size = String.valueOf(pageSize);
        jsonRequest.deliver_food = "";
        jsonRequest.page_number = pageNumber;

        Call<JsonResponse> call = apiServices.getRestaurantsList(CommonUtils.getPreferences(this, AppConstant.AppToken), jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {
                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {
                    if (response.body().responseCode.equalsIgnoreCase("200")) {
                        if (response.body().restaurant_list != null && response.body().restaurant_list.size() > 0) {
                            if(pageNo==1)
                                restaurantList.clear();
                                restaurantList.addAll(response.body().restaurant_list);
                                tvNoOfRestaurants.setText(String.valueOf(response.body().pagination.total_record_count));
                                bestRestaurantAdapter.notifyDataSetChanged();
                                rvRestaurants.setNestedScrollingEnabled(false);
                                pageNo++;


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

    /******************************
     * Cuisine Restaurant List Api
     ******************************/

    private void getCuisineRestaurantListApi() {
        CommonUtils.showProgressDialog(context);
        ApiInterface apiServices = ApiClient.getClient(this).create(ApiInterface.class);
        final JsonRequest jsonRequest = new JsonRequest();
        jsonRequest.type = "cuisine";
        jsonRequest.search_content = "";

        Call<JsonResponse> call = apiServices.getCuisineRestaurantList(CommonUtils.getPreferences(this, AppConstant.AppToken), jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {

                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {

                    if (response.body().responseCode.equalsIgnoreCase("200")) {

                        if (response.body().allList != null && response.body().allList.size() > 0) {
                            cuisineList.clear();
                            cuisineList.addAll(response.body().allList);
                            _searchableListDialog = SearchableListDialog.newInstance
                                    (cuisineList);
                            selectedItem = "cuisine";
                            _searchableListDialog.setOnSearchableItemClickListener(BestRestaurantNearCity.this);
                            _searchableListDialog.show(getFragmentManager(), TAG);
                            _searchableListDialog.setTitle(getString(R.string.select));
                            Log.d(TAG, "Number of data received: " + cuisineList.size());
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


    /******************************
     * Dietary Restaurant List Api
     ******************************/
    private void getDietaryRestaurantListApi() {
        CommonUtils.showProgressDialog(context);
        ApiInterface apiServices = ApiClient.getClient(this).create(ApiInterface.class);
        final JsonRequest jsonRequest = new JsonRequest();
        jsonRequest.type = "dietary";
        jsonRequest.search_content = "";

        Call<JsonResponse> call = apiServices.getDietaryRestaurantList(CommonUtils.getPreferences(this, AppConstant.AppToken), jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {

                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {

                    if (response.body().responseCode.equalsIgnoreCase("200")) {

                        if (response.body().allList != null && response.body().allList.size() > 0) {
                            cuisineList.clear();
                            cuisineList.addAll(response.body().allList);
                            _searchableListDialog = SearchableListDialog.newInstance
                                    (cuisineList);
                            selectedItem = "dietary";
                            _searchableListDialog.setOnSearchableItemClickListener(BestRestaurantNearCity.this);
                            _searchableListDialog.show(getFragmentManager(), TAG);
                            _searchableListDialog.setTitle(getString(R.string.select));


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


    /********************
     * Ambience Restaurant Api
     ********************/


    private void getAmbienceRestaurantListApi() {
        CommonUtils.showProgressDialog(context);
        ApiInterface apiServices = ApiClient.getClient(this).create(ApiInterface.class);
        final JsonRequest jsonRequest = new JsonRequest();
        jsonRequest.type = "ambience";
        jsonRequest.search_content = "";

        Call<JsonResponse> call = apiServices.getAmbienceRestaurantList(CommonUtils.getPreferences(this, AppConstant.AppToken), jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {

                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {

                    if (response.body().responseCode.equalsIgnoreCase("200")) {

                        if (response.body().allList != null && response.body().allList.size() > 0) {
                            cuisineList.clear();
                            cuisineList.addAll(response.body().allList);


                            _searchableListDialog = SearchableListDialog.newInstance
                                    (cuisineList);
                            selectedItem = "ambience";

                            _searchableListDialog.setOnSearchableItemClickListener(BestRestaurantNearCity.this);
                            _searchableListDialog.show(getFragmentManager(), TAG);
                            _searchableListDialog.setTitle(getString(R.string.select));

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


    /********************
     * Location Restaurant Api
     ********************/


    private void getLocationRestaurantListApi() {
        CommonUtils.showProgressDialog(context);
        ApiInterface apiServices = ApiClient.getClient(this).create(ApiInterface.class);
        final JsonRequest jsonRequest = new JsonRequest();
        jsonRequest.type = "location";
        jsonRequest.latitude = String.valueOf(currentLat);
        jsonRequest.longitude = String.valueOf(currentLong);
        jsonRequest.search_content = "";

        Call<JsonResponse> call = apiServices.getLocationRestaurantList(CommonUtils.getPreferences(this, AppConstant.AppToken), jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {

                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {

                    if (response.body().responseCode.equalsIgnoreCase("200")) {

                        if (response.body().allList != null && response.body().allList.size() > 0) {
                            cuisineList.clear();
                            cuisineList.addAll(response.body().allList);

                            _searchableListDialog = SearchableListDialog.newInstance
                                    (cuisineList);
                            selectedItem = "location";
                            _searchableListDialog.setOnSearchableItemClickListener(BestRestaurantNearCity.this);
                            _searchableListDialog.show(getFragmentManager(), TAG);
                            _searchableListDialog.setTitle(getString(R.string.select));


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


    /************************
     * Meal Type Restaurant Api
     *****************/


    private void getMealRestaurantListApi() {
        CommonUtils.showProgressDialog(context);
        ApiInterface apiServices = ApiClient.getClient(this).create(ApiInterface.class);
        final JsonRequest jsonRequest = new JsonRequest();
        jsonRequest.type = "meal";
        jsonRequest.search_content = tvMealType.getText().toString().trim();

        Call<JsonResponse> call = apiServices.getMealRestaurantList(CommonUtils.getPreferences(this, AppConstant.AppToken), jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {

                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {

                    if (response.body().responseCode.equalsIgnoreCase("200")) {

                        if (response.body().allList != null && response.body().allList.size() > 0) {
                            cuisineList.clear();
                            cuisineList.addAll(response.body().allList);
                            _searchableListDialog = SearchableListDialog.newInstance
                                    (cuisineList);
                            selectedItem = "meal";
                            _searchableListDialog.setOnSearchableItemClickListener(BestRestaurantNearCity.this);
                            _searchableListDialog.show(getFragmentManager(), TAG);
                            _searchableListDialog.setTitle(getString(R.string.select));
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


    @Override
    public void onSearchableItemClicked(Object item, int position) {

        Cuisine cuisine = (Cuisine) item;
        switch (selectedItem) {

            case "cuisine":
                tvCuisineType.setText(cuisine.name);
                pageNo=1;
                cuisineId = cuisine.id;
                locationId = "";
                dietaryId = "";
                mealId = "";
                ambienceId = "";
                tvLocationType.setText("");
                tvDietaryType.setText("");
                tvMealType.setText("");
                tvBusiness.setText("");
                isRestaurant = true;
                searched_item_name = cuisine.name;
                callsearchedTextApi(pageNo,cuisine.name);
                scrollListener.resetState();
                break;
            case "location":
                tvLocationType.setText(cuisine.name);
            //    tvLocationName.setText(cuisine.name);
                pageNo=1;
                locationId = cuisine.id;
                dietaryId = "";
                mealId = "";
                ambienceId = "";
                cuisineId = "";
                tvDietaryType.setText("");
                tvMealType.setText("");
                tvBusiness.setText("");
                tvCuisineType.setText("");
                searched_item_name = cuisine.name;
                isRestaurant = true;
                callsearchedTextApi(pageNo,searched_item_name);
                scrollListener.resetState();
                break;
            case "dietary":
                tvDietaryType.setText(cuisine.name);
             //   tvLocationName.setText(cuisine.name);
                pageNo=1;
                dietaryId = cuisine.id;
                mealId = "";
                ambienceId = "";
                cuisineId = "";
                locationId = "";
                tvMealType.setText("");
                tvBusiness.setText("");
                tvCuisineType.setText("");
                tvLocationType.setText("");
                searched_item_name = cuisine.name;
                callsearchedTextApi(pageNo,searched_item_name);
                scrollListener.resetState();
                isRestaurant = true;
                break;
            case "meal":
                tvMealType.setText(cuisine.name);
             //   tvLocationName.setText(cuisine.name);
                pageNo=1;
                mealId = cuisine.id;
                ambienceId = "";
                cuisineId = "";
                locationId = "";
                tvBusiness.setText("");
                tvCuisineType.setText("");
                tvLocationType.setText("");
                tvDietaryType.setText("");
                searched_item_name = cuisine.name;
                callsearchedTextApi(pageNo,searched_item_name);
                scrollListener.resetState();
                isRestaurant = true;
                break;
            case "ambience":
                tvBusiness.setText(cuisine.name);
               // tvLocationName.setText(cuisine.name);
                ambienceId = cuisine.id;
                pageNo=1;
                cuisineId = "";
                locationId = "";
                mealId = "";
                dietaryId = "";
                tvCuisineType.setText("");
                tvLocationType.setText("");
                tvDietaryType.setText("");
                tvMealType.setText("");
                searched_item_name = cuisine.name;
                callsearchedTextApi(pageNo,searched_item_name);
                scrollListener.resetState();
                isRestaurant = true;
                break;
        }
    }

    /************************
     * Search  Api
     ***********************/

    private void callsearchedTextApi(int pageNumber, final String name) {

        CommonUtils.showProgressDialog(context);
        ApiInterface apiServices = ApiClient.getClient(this).create(ApiInterface.class);
        final JsonRequest jsonRequest = new JsonRequest();
        jsonRequest.cusine = cuisineId;
        jsonRequest.dietary = dietaryId;
        jsonRequest.meal = mealId;
        jsonRequest.ambience = ambienceId;
        jsonRequest.location = locationId;
        jsonRequest.deliver_food="0";
        jsonRequest.latitude = String.valueOf(currentLat);
        jsonRequest.longitude = String.valueOf(currentLong);
        jsonRequest.page_number = pageNumber;
        jsonRequest.page_size = String.valueOf(pageSize);

        Call<JsonResponse> call = apiServices.getSearchRestaurantApi(CommonUtils.getPreferences(this, AppConstant.AppToken), jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {

                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {

                    if (response.body().responseCode.equalsIgnoreCase("200")) {
                        if (response.body().restaurant_list != null && response.body().restaurant_list.size() > 0) {
                            if(pageNo==1)
                            restaurantList.clear();
                            restaurantList.addAll(response.body().restaurant_list);
                            tvLocationName.setText(name);
                            tvNoOfRestaurants.setText(String.valueOf(response.body().pagination.total_record_count));
                            bestRestaurantAdapter.notifyDataSetChanged();
                            rvRestaurants.setNestedScrollingEnabled(false);
                            pageNo++;
                        } else {
                            Toast.makeText(context, "No restaurant available for "+name, Toast.LENGTH_LONG).show();
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
            }
        });
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
}
