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
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;
import com.podd.R;
import com.podd.adapter.BestRestaurantAdapter;
import com.podd.location.LocationResult;
import com.podd.location.LocationTracker;
import com.podd.model.Cuisine;
import com.podd.retrofit.ApiClient;
import com.podd.retrofit.ApiInterface;
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
    private TextView tvBusiness;
    private TextView tvAmbience;
    private TextView tvMealType;
    private TextView tvMeal;
    private TextView tvCuisinetype;
    private TextView tvCuisine;
    private TextView tvDietary;
    private TextView tvLocationType;
    private TextView tvLocation;
    private TextView tvDietaryType;
    private TextView tvSearchBy;
    private TextView tvCityName;
    private TextView tvNearbyRestaurant;
    private LinearLayout llLocation;
    private LinearLayout llDietary;
    private LinearLayout llCuisine;
    private LinearLayout llMeal;
    private LinearLayout llAmbience;
    private LinearLayout llDeliveredToYou;
    private double currentLat =0.0d;
    private double currentLong=0.0d;
    private List<Cuisine>cuisine=new ArrayList<>();
    private String TAG=BestRestaurantNearCity.class.getSimpleName();


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_best_restaurant_near_city);
        context=BestRestaurantNearCity.this;
        getIds();
        setListeners();
        setRecycler();
        fetchLocation();
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
        rvRestaurants= (RecyclerView) findViewById(R.id.rvRestaurants);
        llDeliveredToYou= (LinearLayout) findViewById(R.id.llDeliveredToYou);
        llAmbience= (LinearLayout) findViewById(R.id.llAmbience);
        llMeal= (LinearLayout) findViewById(R.id.llMeal);
        llCuisine= (LinearLayout) findViewById(R.id.llCuisine);
        llDietary= (LinearLayout) findViewById(R.id.llDietary);
        llLocation= (LinearLayout) findViewById(R.id.llLocation);
        tvNearbyRestaurant= (TextView) findViewById(R.id.tvNearbyRestaurant);
        tvCityName= (TextView) findViewById(R.id.tvCityName);
        tvSearchBy= (TextView) findViewById(R.id.tvSearchBy);
        tvDietaryType= (TextView) findViewById(R.id.tvDietaryType);
        tvLocation= (TextView) findViewById(R.id.tvLocation);
        tvLocationType= (TextView) findViewById(R.id.tvLocationType);
        tvDietary= (TextView) findViewById(R.id.tvDietary);
        tvCuisine= (TextView) findViewById(R.id.tvCuisine);
        tvCuisinetype= (TextView) findViewById(R.id.tvCuisinetype);
        tvMeal= (TextView) findViewById(R.id.tvMeal);
        tvMealType= (TextView) findViewById(R.id.tvMealType);
        tvAmbience= (TextView) findViewById(R.id.tvAmbience);
        tvBusiness= (TextView) findViewById(R.id.tvBusiness);
        tvDeliveredtoYou= (TextView) findViewById(R.id.tvDeliveredtoYou);


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

    private void fetchLocation(){
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

                    if (addresses.size()>0) {
                        String address = TextUtils.isEmpty(addresses.get(0).getAddressLine(0))?"":addresses.get(0).getAddressLine(0); // If any additional address line present than only, check with max available address lines by getMaxAddressLineIndex()
                        String area = TextUtils.isEmpty(addresses.get(0).getSubLocality())?"":", "+addresses.get(0).getSubLocality();
                        String city = TextUtils.isEmpty(addresses.get(0).getLocality())?"":addresses.get(0).getLocality();
                        String state = TextUtils.isEmpty(addresses.get(0).getAdminArea())?"":addresses.get(0).getAdminArea();
                        String country = TextUtils.isEmpty(addresses.get(0).getCountryName())?"":addresses.get(0).getCountryName();
                        String postalCode = TextUtils.isEmpty(addresses.get(0).getPostalCode())?"":addresses.get(0).getPostalCode();
                        String knownName = TextUtils.isEmpty(addresses.get(0).getFeatureName())?"":addresses.get(0).getFeatureName(); // Only if available else return NULL

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

                        tvCityName.setText(city);
                    }else {
                    }

                } catch (Exception e) {
                    e.printStackTrace();
                }
            }
        }).onUpdateLocation();
    }


    private void setRecycler() {
        GridLayoutManager gridLayoutManager = new GridLayoutManager(context,2,LinearLayoutManager.HORIZONTAL,false);
        rvRestaurants.setLayoutManager(gridLayoutManager);
        bestRestaurantAdapter = new BestRestaurantAdapter(context);
        rvRestaurants.setAdapter(bestRestaurantAdapter);
        rvRestaurants.setNestedScrollingEnabled(false);
    }




    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.llAmbience:
                Toast.makeText(context,R.string.work_in_progress,Toast.LENGTH_SHORT).show();
                break;
            case R.id.llLocation:
                Toast.makeText(context,R.string.work_in_progress,Toast.LENGTH_SHORT).show();
                break;
            case R.id.llDietary:
                Toast.makeText(context,R.string.work_in_progress,Toast.LENGTH_SHORT).show();
                break;
            case R.id.llCuisine:
                tvNearbyRestaurant.setText(R.string.restaurant_by_cuisine);
                tvCityName.setVisibility(View.GONE);
               getCuisineRestaurantListApi();
                break;
            case R.id.llMeal:
                Toast.makeText(context,R.string.work_in_progress,Toast.LENGTH_SHORT).show();
                break;
            case R.id.llDeliveredToYou:
                Toast.makeText(context,R.string.work_in_progress,Toast.LENGTH_SHORT).show();
                break;

        }

    }

      private void getCuisineRestaurantListApi() {
          ApiInterface apiService =
                  ApiClient.getClient(context).create(ApiInterface.class);
          JsonRequest jsonRequest= new JsonRequest();
          jsonRequest.type="cuisine";
          Call<JsonResponse> call = apiService.getCuisineRestaurantList(jsonRequest);
          call.enqueue(new Callback<JsonResponse>() {
              @Override
              public void onResponse(Call<JsonResponse>call, Response<JsonResponse> response) {
                  if (response.body()!=null)
                cuisine=response.body().allList;
                  Log.d(TAG, "Number of data received: " + cuisine.size());
              }

              @Override
              public void onFailure(Call<JsonResponse>call, Throwable t) {
                  Log.e(TAG, t.toString());

              }
          });

    }

}
