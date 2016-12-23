package com.podd.activityrestauarant;

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
import android.widget.AutoCompleteTextView;
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
import com.podd.utils.CommonUtils;
import com.podd.webservices.JsonRequest;
import com.podd.webservices.JsonResponse;

import java.util.ArrayList;
import java.util.List;
import java.util.Locale;


import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;


/**
 * The type Best restaurant near city.
 */
public class BestRestaurantNearCity extends AppCompatActivity implements View.OnClickListener {

    private RecyclerView rvRestaurants;
    private Context context;
    private BestRestaurantAdapter bestRestaurantAdapter;
    private TextView tvDeliveredtoYou;
    private AutoCompleteTextView tvBusiness;
    private TextView tvAmbience;
    private AutoCompleteTextView tvMealType;
    private TextView tvMeal;
    private AutoCompleteTextView tvCuisinetype;
    private TextView tvCuisine;
    private TextView tvDietary;
    private AutoCompleteTextView tvLocationType;
    private TextView tvLocation;
    private AutoCompleteTextView tvDietaryType;
    private TextView tvSearchBy;
    private TextView tvCityName;
    private TextView tvNearbyRestaurant;
    private LinearLayout llLocation;
    private LinearLayout llDietary;
    private LinearLayout llCuisine;
    private LinearLayout llMeal;
    private LinearLayout llAmbience;
    private LinearLayout llDeliveredToYou;
    private double currentLat = 0.0d;
    private double currentLong = 0.0d;
    private List<Cuisine> cuisineList = new ArrayList<>();
    private List<Restaurant> restaurantList = new ArrayList<>();
    private String TAG = BestRestaurantNearCity.class.getSimpleName();
    private final String[] location = {"abc", "abd", "aaa", "aaaa"};
    private final String[] dietary = {"bbb", "abd", "bba", "bbc"};
    private final String[] cuisine = {"abc", "ccc", "aca", "acaa"};
    private final String[] meal = {"ddd", "dddd", "dddd", "ddddd"};
    private final String[] ambience = {"rrr", "rrrrrrr", "rrrrr", "rrrr"};
    private int pageNo = 1;
    private CuisineTypeRestaurantAdapter cuisineTypeRestaurantAdapter;



    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_best_restaurant_near_city);
        context = BestRestaurantNearCity.this;
        getIds();
        setListeners();
       /* setRecycler();*/
        if (CommonUtils.isOnline(context)) {
            fetchLocation();
        } else {
            Toast.makeText(context, R.string.Please_connect_to_internet_first, Toast.LENGTH_SHORT).show();
        }

        selectLocation();
        selectAmbience();
        selectCuisine();
        selectDietary();
        selectMeal();
    }

    private void selectLocation() {
        ArrayAdapter adapter = new ArrayAdapter(context, R.layout.row_report_type_dropdown, location);
        tvLocationType.setAdapter(adapter);
    }

    private void selectDietary() {
        ArrayAdapter adapter = new ArrayAdapter(context, R.layout.row_report_type_dropdown, dietary);
        tvDietaryType.setAdapter(adapter);
    }

    private void selectCuisine() {
        ArrayAdapter adapter = new ArrayAdapter(context, R.layout.row_report_type_dropdown, cuisine);
        tvCuisinetype.setAdapter(adapter);
    }

    private void selectMeal() {
        ArrayAdapter adapter = new ArrayAdapter(context, R.layout.row_report_type_dropdown, meal);
        tvMealType.setAdapter(adapter);
    }

    private void selectAmbience() {
        ArrayAdapter adapter = new ArrayAdapter(context, R.layout.row_report_type_dropdown, ambience);
        tvBusiness.setAdapter(adapter);
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
        tvSearchBy = (TextView) findViewById(R.id.tvSearchBy);
        tvDietaryType = (AutoCompleteTextView) findViewById(R.id.tvDietaryType);
        tvLocation = (TextView) findViewById(R.id.tvLocation);
        tvLocationType = (AutoCompleteTextView) findViewById(R.id.tvLocationType);
        tvDietary = (TextView) findViewById(R.id.tvDietary);
        tvCuisine = (TextView) findViewById(R.id.tvCuisine);
        tvCuisinetype = (AutoCompleteTextView) findViewById(R.id.tvCuisinetype);
        tvMeal = (TextView) findViewById(R.id.tvMeal);
        tvMealType = (AutoCompleteTextView) findViewById(R.id.tvMealType);
        tvAmbience = (TextView) findViewById(R.id.tvAmbience);
        tvBusiness = (AutoCompleteTextView) findViewById(R.id.tvBusiness);
        tvDeliveredtoYou = (TextView) findViewById(R.id.tvDeliveredtoYou);


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
        CommonUtils.showProgressDialog(context);
        new LocationTracker(context, new LocationResult() {
            @Override
            public void gotLocation(Location location) {

                currentLat = location.getLatitude();
                currentLong = location.getLongitude();
                Log.i("ChangeLocationActivity", "Location_Latitude" + String.valueOf(currentLat));
                Log.i("ChangeLocationActivity", "Location_Longitude" + String.valueOf(currentLong));
                try {
                    Geocoder geocoder;
                    List<Address> addresses;
                    geocoder = new Geocoder(BestRestaurantNearCity.this, Locale.getDefault());

                    addresses = geocoder.getFromLocation(currentLat, currentLong, 1); // Here 1 represent max location result to returned, by documents it recommended 1 to 5

                    if (addresses.size() > 0) {
                        String address = TextUtils.isEmpty(addresses.get(0).getAddressLine(0)) ? "" : addresses.get(0).getAddressLine(0); // If any additional address line present than only, check with max available address lines by getMaxAddressLineIndex()
                        String area = TextUtils.isEmpty(addresses.get(0).getSubLocality()) ? "" : ", " + addresses.get(0).getSubLocality();
                        String city = TextUtils.isEmpty(addresses.get(0).getLocality()) ? "" : addresses.get(0).getLocality();
                        String state = TextUtils.isEmpty(addresses.get(0).getAdminArea()) ? "" : addresses.get(0).getAdminArea();
                        String country = TextUtils.isEmpty(addresses.get(0).getCountryName()) ? "" : addresses.get(0).getCountryName();
                        String postalCode = TextUtils.isEmpty(addresses.get(0).getPostalCode()) ? "" : addresses.get(0).getPostalCode();
                        String knownName = TextUtils.isEmpty(addresses.get(0).getFeatureName()) ? "" : addresses.get(0).getFeatureName(); // Only if available else return NULL

                        Log.i("ChangeLocationActivity", ":::address:::" + address);
                        Log.i("ChangeLocationActivity", ":::area:::" + area);
                        Log.i("ChangeLocationActivity", ":::city:::" + city);
                        Log.i("ChangeLocationActivity", ":::state:::" + state);
                        Log.i("ChangeLocationActivity", ":::country:::" + country);
                        Log.i("ChangeLocationActivity", ":::postalCode:::" + postalCode);
                        Log.i("ChangeLocationActivity", ":::knownName:::" + knownName);
                        if (address.equalsIgnoreCase("null"))
                            address = "";
                        if (area.equalsIgnoreCase(", null"))
                            area = "";
                        if (city.equalsIgnoreCase("null"))
                            city = "";
                        if (country.equalsIgnoreCase("null"))
                            country = "";
                        CommonUtils.disMissProgressDialog(context);
                        tvCityName.setText(address);
                        getRestaurantListApi(currentLat, currentLong, pageNo);
                    } else {


                    }

                } catch (Exception e) {
                    e.printStackTrace();
                }
            }
        }).onUpdateLocation();
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


    /******************************Restaurant List Api******************************/

    private void getRestaurantListApi(final double currentLat, double currentLong, int pageNumber) {
        CommonUtils.showProgressDialog(context);
        final JsonRequest jsonRequest = new JsonRequest();
        jsonRequest.latitude = String.valueOf(currentLat);
        jsonRequest.longitude = String.valueOf(currentLong);
        jsonRequest.page_size = "10";
        jsonRequest.page_number = pageNumber;
        Log.e(TAG, "" + new Gson().toJsonTree(jsonRequest).toString().trim());
        Call<JsonResponse> call = ApiClient.getApiService().getRestautantsList(jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {
                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {
                    Log.e(TAG, "" + new Gson().toJsonTree(response.body().toString().trim()));
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

    /******************************Cuisine Restaurant List Api******************************/

    private void getCuisineRestaurantListApi() {
        CommonUtils.showProgressDialog(context);

        final JsonRequest jsonRequest = new JsonRequest();
        jsonRequest.type = "cuisine";
        jsonRequest.search_content=tvCuisinetype.getText().toString().trim();
        Log.e(TAG, "" + new Gson().toJsonTree(jsonRequest).toString().trim());

        Call<JsonResponse> call = ApiClient.getApiService().getCuisineRestaurantList(jsonRequest);
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
                            GridLayoutManager gridLayoutManager = new GridLayoutManager(context, 2, LinearLayoutManager.HORIZONTAL, false);
                            rvRestaurants.setLayoutManager(gridLayoutManager);
                            cuisineTypeRestaurantAdapter = new CuisineTypeRestaurantAdapter(context, cuisineList);
                            rvRestaurants.setAdapter(cuisineTypeRestaurantAdapter);
                            rvRestaurants.setNestedScrollingEnabled(false);
                            Log.d(TAG, "Number of data received: " + cuisineList.size());
                        }
                        else {
                            Toast.makeText(context, R.string.data_not_found, Toast.LENGTH_SHORT).show();
                        }
                    }
                    else {
                        Toast.makeText(context, response.body().responseMessage, Toast.LENGTH_SHORT).show();
                    }
                }
                else {
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



    /******************************Dietary Restaurant List Api******************************/
    private void getDietaryRestaurantListApi() {
        CommonUtils.showProgressDialog(context);

        final JsonRequest jsonRequest = new JsonRequest();
        jsonRequest.type = "dietary";
        jsonRequest.search_content=tvDietaryType.getText().toString().trim();
        Log.e(TAG, "" + new Gson().toJsonTree(jsonRequest).toString().trim());

        Call<JsonResponse> call = ApiClient.getApiService().getDietaryRestaurantList(jsonRequest);
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
                            GridLayoutManager gridLayoutManager = new GridLayoutManager(context, 2, LinearLayoutManager.HORIZONTAL, false);
                            rvRestaurants.setLayoutManager(gridLayoutManager);
                            cuisineTypeRestaurantAdapter = new CuisineTypeRestaurantAdapter(context, cuisineList);
                            rvRestaurants.setAdapter(cuisineTypeRestaurantAdapter);
                            rvRestaurants.setNestedScrollingEnabled(false);
                            Log.d(TAG, "Number of data received: " + cuisineList.size());
                        }
                        else {
                            Toast.makeText(context, R.string.data_not_found, Toast.LENGTH_SHORT).show();
                        }
                    }
                    else {
                        Toast.makeText(context, response.body().responseMessage, Toast.LENGTH_SHORT).show();
                    }
                }
                else {
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



    /********************Ambience Restaurant Api********************/


    private void getAmbienceRestaurantListApi() {
        CommonUtils.showProgressDialog(context);

        final JsonRequest jsonRequest = new JsonRequest();
        jsonRequest.type = "ambience";
        jsonRequest.search_content=tvBusiness.getText().toString().trim();
        Log.e(TAG, "" + new Gson().toJsonTree(jsonRequest).toString().trim());

        Call<JsonResponse> call = ApiClient.getApiService().getAmbienceRestaurantList(jsonRequest);
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
                            GridLayoutManager gridLayoutManager = new GridLayoutManager(context, 2, LinearLayoutManager.HORIZONTAL, false);
                            rvRestaurants.setLayoutManager(gridLayoutManager);
                            cuisineTypeRestaurantAdapter = new CuisineTypeRestaurantAdapter(context, cuisineList);
                            rvRestaurants.setAdapter(cuisineTypeRestaurantAdapter);
                            rvRestaurants.setNestedScrollingEnabled(false);
                            Log.d(TAG, "Number of data received: " + cuisineList.size());
                        }
                        else {
                            Toast.makeText(context, R.string.data_not_found, Toast.LENGTH_SHORT).show();
                        }
                    }
                    else {
                        Toast.makeText(context, response.body().responseMessage, Toast.LENGTH_SHORT).show();
                    }
                }
                else {
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



    /********************Location Restaurant Api********************/


    private void getLocationRestaurantListApi() {
        CommonUtils.showProgressDialog(context);

        final JsonRequest jsonRequest = new JsonRequest();
        jsonRequest.type = "location";
        jsonRequest.search_content=tvLocationType.getText().toString().trim();
        Log.e(TAG, "" + new Gson().toJsonTree(jsonRequest).toString().trim());

        Call<JsonResponse> call = ApiClient.getApiService().getLocationRestaurantList(jsonRequest);
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
                            GridLayoutManager gridLayoutManager = new GridLayoutManager(context, 2, LinearLayoutManager.HORIZONTAL, false);
                            rvRestaurants.setLayoutManager(gridLayoutManager);
                            cuisineTypeRestaurantAdapter = new CuisineTypeRestaurantAdapter(context, cuisineList);
                            rvRestaurants.setAdapter(cuisineTypeRestaurantAdapter);
                            rvRestaurants.setNestedScrollingEnabled(false);
                            Log.d(TAG, "Number of data received: " + cuisineList.size());
                        }
                        else {
                            Toast.makeText(context, R.string.data_not_found, Toast.LENGTH_SHORT).show();
                        }
                    }
                    else {
                        Toast.makeText(context, response.body().responseMessage, Toast.LENGTH_SHORT).show();
                    }
                }
                else {
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



    /************************Meal Type Restaurant Api*****************/


    private void getMealRestaurantListApi() {
        CommonUtils.showProgressDialog(context);

        final JsonRequest jsonRequest = new JsonRequest();
        jsonRequest.type = "meal";
        jsonRequest.search_content=tvMealType.getText().toString().trim();
        Log.e(TAG, "" + new Gson().toJsonTree(jsonRequest).toString().trim());

        Call<JsonResponse> call = ApiClient.getApiService().getMealRestaurantList(jsonRequest);
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
                            GridLayoutManager gridLayoutManager = new GridLayoutManager(context, 2, LinearLayoutManager.HORIZONTAL, false);
                            rvRestaurants.setLayoutManager(gridLayoutManager);
                            cuisineTypeRestaurantAdapter = new CuisineTypeRestaurantAdapter(context, cuisineList);
                            rvRestaurants.setAdapter(cuisineTypeRestaurantAdapter);
                            rvRestaurants.setNestedScrollingEnabled(false);
                            Log.d(TAG, "Number of data received: " + cuisineList.size());
                        }
                        else {
                            Toast.makeText(context, R.string.data_not_found, Toast.LENGTH_SHORT).show();
                        }
                    }
                    else {
                        Toast.makeText(context, response.body().responseMessage, Toast.LENGTH_SHORT).show();
                    }
                }
                else {
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
