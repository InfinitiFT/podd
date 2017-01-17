package com.podd.activityRestaurant;

import android.content.Context;
import android.location.Address;
import android.location.Geocoder;
import android.location.Location;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.Toolbar;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.google.gson.Gson;
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
import com.podd.webservices.JsonRequest;
import com.podd.webservices.JsonResponse;

import java.util.ArrayList;
import java.util.List;
import java.util.Locale;


import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;


public class BestRestaurantNearCity extends AppCompatActivity implements View.OnClickListener, SearchableListDialog.SearchableItem {

    private RecyclerView rvRestaurants;
    private Context context;
    private BestRestaurantAdapter bestRestaurantAdapter;
    private TextView tvBusiness;
    private TextView tvMealType;
    private TextView tvCuisineType;
    private TextView tvLocationType;
    private TextView tvDietaryType;
    private TextView tvCityName;
    private TextView tvNearbyRestaurant;
    private LinearLayout llLocation;
    private LinearLayout llDietary;
    private LinearLayout llCuisine;
    private LinearLayout llMeal;
    private LinearLayout llAmbience;
    private LinearLayout llDeliveredToYou;
    private double currentLat;
    private double currentLong;
    private List<Cuisine> cuisineList = new ArrayList<>();
    private List<Restaurant> restaurantList = new ArrayList<>();
    private List<String> location = new ArrayList<>();
    private String TAG = BestRestaurantNearCity.class.getSimpleName();
    private int pageNo = 1;
    private CuisineTypeRestaurantAdapter cuisineTypeRestaurantAdapter;
    private ArrayAdapter adapterLocation;
    private SearchableListDialog _searchableListDialog;
    private List<String> categories;
    private String selectedItem = "";
    private String cuisineId;
    private String locationId;
    private String mealId;
    private String dietaryId;
    private String ambienceId;
    private GridLayoutManager gridLayoutManager;
    private EndlessScrollListener scrollListener;
    private boolean isRestaurant = false;
    private int pageSize = 10;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_best_restaurant_near_city);
        context = BestRestaurantNearCity.this;
        getIds();
        setListeners();
        gridLayoutManager = new GridLayoutManager(context, 2, LinearLayoutManager.HORIZONTAL, false);
        fetchLocation();


        try {
            scrollListener = new EndlessScrollListener(gridLayoutManager) {
                @Override
                public void onLoadMore(int page, int totalItemsCount, RecyclerView view) {
                    // Triggered only when new data needs to be appended to the list
                    // Add whatever code is needed to append new items to the bottom of the list

                    if (!isRestaurant) {
                        if (restaurantList.size() % pageSize == 0)
                            getRestaurantListApi(currentLat, currentLong, pageNo);
                    } else {
                        if (restaurantList.size() % pageSize == 0)
                            callsearchedTextApi(pageNo);
                    }
                }
            };
            // Adds the scroll listener to RecyclerView
            rvRestaurants.addOnScrollListener(scrollListener);
        } catch (Exception exc) {
            exc.printStackTrace();
        }
        rvRestaurants.addOnScrollListener(scrollListener);

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
        tvNearbyRestaurant = (TextView) findViewById(R.id.tvNearbyRestaurant);
        tvCityName = (TextView) findViewById(R.id.tvCityName);
        TextView tvSearchBy = (TextView) findViewById(R.id.tvSearchBy);
        tvDietaryType = (TextView) findViewById(R.id.tvDietaryType);
        TextView tvLocation = (TextView) findViewById(R.id.tvLocation);
        tvLocationType = (TextView) findViewById(R.id.tvLocationType);
        TextView tvDietary = (TextView) findViewById(R.id.tvDietary);
        TextView tvCuisine = (TextView) findViewById(R.id.tvCuisine);
        tvCuisineType = (TextView) findViewById(R.id.tvCuisineType);
        TextView tvMeal = (TextView) findViewById(R.id.tvMeal);
        tvMealType = (TextView) findViewById(R.id.tvMealType);
        TextView tvAmbience = (TextView) findViewById(R.id.tvAmbience);
        tvBusiness = (TextView) findViewById(R.id.tvBusiness);
        TextView tvDeliveredtoYou = (TextView) findViewById(R.id.tvDeliveredToYou);


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

    private void fetchLocation() {
        new LocationTracker(context, new LocationResult() {
            @Override
            public void gotLocation(Location location) {
                currentLat = location.getLatitude();
                currentLong = location.getLongitude();
                /*currentLat = 51.4662;
                currentLong = 0.1617;*/
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
                tvCityName.setText(response.body().results.get(0).formatted_address);
                getRestaurantListApi(currentLat, currentLong, pageNo);
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
                tvCityName.setVisibility(View.GONE);
                tvNearbyRestaurant.setText(R.string.restaurant_by_ambience);
                getAmbienceRestaurantListApi();
                break;
            case R.id.llLocation:
                tvCityName.setVisibility(View.GONE);
                tvNearbyRestaurant.setText(R.string.restaurant_by_location);
                getLocationRestaurantListApi();
                break;
            case R.id.llDietary:
                tvCityName.setVisibility(View.GONE);
                tvNearbyRestaurant.setText(R.string.restaurant_by_dietary);
                getDietaryRestaurantListApi();
                break;
            case R.id.llCuisine:
                tvNearbyRestaurant.setText(R.string.restaurant_by_cuisine);
                tvCityName.setVisibility(View.GONE);
                getCuisineRestaurantListApi();
                break;
            case R.id.llMeal:
                tvNearbyRestaurant.setText(R.string.restaurant_by_meal);
                tvCityName.setVisibility(View.GONE);
                getMealRestaurantListApi();
                break;
            case R.id.llDeliveredToYou:
                tvNearbyRestaurant.setText(R.string.delivered_to_you);
                tvCityName.setVisibility(View.GONE);
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

        Log.e(TAG, "" + new Gson().toJsonTree(jsonRequest).toString().trim());
        Call<JsonResponse> call = apiServices.getRestaurantsList(CommonUtils.getPreferences(this, AppConstant.AppToken), jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {
                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {
                    if (response.body().responseCode.equalsIgnoreCase("200")) {
                        if (response.body().restaurant_list != null && response.body().restaurant_list.size() > 0) {
                            restaurantList.clear();
                            restaurantList.addAll(response.body().restaurant_list);

                            rvRestaurants.setLayoutManager(gridLayoutManager);
                            bestRestaurantAdapter = new BestRestaurantAdapter(context, restaurantList);
                            rvRestaurants.setAdapter(bestRestaurantAdapter);
                            rvRestaurants.setNestedScrollingEnabled(false);
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
        Log.e(TAG, "" + new Gson().toJsonTree(jsonRequest).toString().trim());

        Call<JsonResponse> call = apiServices.getCuisineRestaurantList(CommonUtils.getPreferences(this, AppConstant.AppToken), jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {

                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {

                    Log.e(TAG, "" + new Gson().toJsonTree(response.body().toString().trim()));

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
        Log.e(TAG, "" + new Gson().toJsonTree(jsonRequest).toString().trim());

        Call<JsonResponse> call = apiServices.getDietaryRestaurantList(CommonUtils.getPreferences(this, AppConstant.AppToken), jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {

                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {

                    Log.e(TAG, "" + new Gson().toJsonTree(response.body().toString().trim()));

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
        Log.e(TAG, "" + new Gson().toJsonTree(jsonRequest).toString().trim());

        Call<JsonResponse> call = apiServices.getAmbienceRestaurantList(CommonUtils.getPreferences(this, AppConstant.AppToken), jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {

                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {

                    Log.e(TAG, "" + new Gson().toJsonTree(response.body().toString().trim()));

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
        jsonRequest.search_content = "";
        Log.e(TAG, "" + new Gson().toJsonTree(jsonRequest).toString().trim());

        Call<JsonResponse> call = apiServices.getLocationRestaurantList(CommonUtils.getPreferences(this, AppConstant.AppToken), jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {

                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {

                    Log.e(TAG, "" + new Gson().toJsonTree(response.body().toString().trim()));

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

                            /*GridLayoutManager gridLayoutManager = new GridLayoutManager(context, 2, LinearLayoutManager.HORIZONTAL, false);
                            rvRestaurants.setLayoutManager(gridLayoutManager);
                            cuisineTypeRestaurantAdapter = new CuisineTypeRestaurantAdapter(context, cuisineList);
                            rvRestaurants.setAdapter(cuisineTypeRestaurantAdapter);
                            rvRestaurants.setNestedScrollingEnabled(false);
                            Log.d(TAG, "Number of data received: " + cuisineList.size());*/
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
        Log.e(TAG, "" + new Gson().toJsonTree(jsonRequest).toString().trim());

        Call<JsonResponse> call = apiServices.getMealRestaurantList(CommonUtils.getPreferences(this, AppConstant.AppToken), jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {

                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {

                    Log.e(TAG, "" + new Gson().toJsonTree(response.body().toString().trim()));

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
                callsearchedTextApi(pageNo);
                break;
            case "location":
                tvLocationType.setText(cuisine.name);
                locationId = cuisine.id;
                dietaryId = "";
                mealId = "";
                ambienceId = "";
                cuisineId = "";
                tvDietaryType.setText("");
                tvMealType.setText("");
                tvBusiness.setText("");
                tvCuisineType.setText("");
                isRestaurant = true;
                callsearchedTextApi(pageNo);
                break;
            case "dietary":
                tvDietaryType.setText(cuisine.name);
                dietaryId = cuisine.id;
                mealId = "";
                ambienceId = "";
                cuisineId = "";
                locationId = "";
                tvMealType.setText("");
                tvBusiness.setText("");
                tvCuisineType.setText("");
                tvLocationType.setText("");
                callsearchedTextApi(pageNo);
                isRestaurant = true;
                break;
            case "meal":
                tvMealType.setText(cuisine.name);
                mealId = cuisine.id;
                ambienceId = "";
                cuisineId = "";
                locationId = "";
                mealId = "";
                tvBusiness.setText("");
                tvCuisineType.setText("");
                tvLocationType.setText("");
                tvDietaryType.setText("");
                callsearchedTextApi(pageNo);
                isRestaurant = true;
                break;
            case "ambience":
                tvBusiness.setText(cuisine.name);
                ambienceId = cuisine.id;
                cuisineId = "";
                locationId = "";
                mealId = "";
                dietaryId = "";
                tvCuisineType.setText("");
                tvLocationType.setText("");
                tvDietaryType.setText("");
                tvMealType.setText("");
                callsearchedTextApi(pageNo);
                isRestaurant = true;
                break;

        }


       /* GridLayoutManager gridLayoutManager = new GridLayoutManager(context, 2, LinearLayoutManager.HORIZONTAL, false);
        rvRestaurants.setLayoutManager(gridLayoutManager);
        cuisineTypeRestaurantAdapter = new CuisineTypeRestaurantAdapter(context, cuisineList);
        rvRestaurants.setAdapter(cuisineTypeRestaurantAdapter);
        rvRestaurants.setNestedScrollingEnabled(false);
        Log.d(TAG, "Number of data received: " + cuisineList.size());*/

    }

    private void callsearchedTextApi(int pageNumber) {
        CommonUtils.showProgressDialog(context);
        ApiInterface apiServices = ApiClient.getClient(this).create(ApiInterface.class);
        final JsonRequest jsonRequest = new JsonRequest();
        jsonRequest.cusine = cuisineId;
        jsonRequest.dietary = dietaryId;
        jsonRequest.meal = mealId;
        jsonRequest.ambience = ambienceId;
        jsonRequest.location = locationId;
        jsonRequest.latitude = String.valueOf(currentLat);
        jsonRequest.longitude = String.valueOf(currentLong);
        jsonRequest.page_number = pageNumber;
        jsonRequest.page_size = String.valueOf(pageSize);
        Log.e(TAG, "" + new Gson().toJsonTree(jsonRequest).toString().trim());

        Call<JsonResponse> call = apiServices.getSearchRestaurantApi(CommonUtils.getPreferences(this, AppConstant.AppToken), jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {

                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {

                    if (response.body().responseCode.equalsIgnoreCase("200")) {
                        if (response.body().restaurant_list != null && response.body().restaurant_list.size() > 0) {
                            restaurantList.clear();
                            restaurantList.addAll(response.body().restaurant_list);
                            GridLayoutManager gridLayoutManager = new GridLayoutManager(context, 2, LinearLayoutManager.HORIZONTAL, false);
                            rvRestaurants.setLayoutManager(gridLayoutManager);
                            bestRestaurantAdapter = new BestRestaurantAdapter(context, restaurantList);
                            rvRestaurants.setAdapter(bestRestaurantAdapter);
                            rvRestaurants.setNestedScrollingEnabled(false);
                        } else {
                            Toast.makeText(context, "There is no restaurant list.", Toast.LENGTH_SHORT).show();
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
}
