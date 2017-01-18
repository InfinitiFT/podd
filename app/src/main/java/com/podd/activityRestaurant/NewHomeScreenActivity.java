package com.podd.activityRestaurant;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.IntentSender;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationManager;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.Html;
import android.util.Log;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.api.GoogleApiClient;
import com.google.android.gms.common.api.PendingResult;
import com.google.android.gms.common.api.ResultCallback;
import com.google.android.gms.common.api.Status;
import com.google.android.gms.location.LocationRequest;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.location.LocationSettingsRequest;
import com.google.android.gms.location.LocationSettingsResult;
import com.google.android.gms.location.LocationSettingsStatusCodes;
import com.google.gson.Gson;
import com.podd.R;
import com.podd.adapter.BestRestaurantAdapter;
import com.podd.adapter.HomeItemsAdapter;
import com.podd.location.LocationResult;
import com.podd.location.LocationTracker;
import com.podd.model.HomeItemsModel;
import com.podd.retrofit.ApiClient;
import com.podd.retrofit.ApiInterface;
import com.podd.utils.AppConstant;
import com.podd.utils.CommonUtils;
import com.podd.webservices.JsonRequest;
import com.podd.webservices.JsonResponse;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class NewHomeScreenActivity extends AppCompatActivity implements GoogleApiClient.ConnectionCallbacks, LocationResult {
    private ImageView ivRestaurantImage;
    private TextView tvAdminMessage, tvDayDate,tvTime;
    private RecyclerView rvHomeItems;
    private HomeItemsAdapter homeItemsAdapter;
    private Context context;
    private List<HomeItemsModel> homeItemsModelList = new ArrayList<>();
    private Intent intent;
    private int REQUEST_LOCATION=123;
    private LocationManager locationManager;
    private LocationTracker locationTracker;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_new_home_screen);
        context=NewHomeScreenActivity.this;
        getIds();
        setRecycler();
        //setRecyclerData();

        if(CommonUtils.isNetworkConnected(this)){
            callHomeApi();
        }else {
            Toast.makeText(context, R.string.Please_connect_to_internet_first, Toast.LENGTH_SHORT).show();
        }

        locationTracker = new LocationTracker(context, this);
        locationManager = (LocationManager) context.getSystemService(Context.LOCATION_SERVICE);
        checkPermission();

    }

    private void callHomeApi() {
        CommonUtils.showProgressDialog(context);
        ApiInterface apiServices = ApiClient.getClient(this).create(ApiInterface.class);
        Call<JsonResponse> call = apiServices.getServiceList(CommonUtils.getPreferences(this,AppConstant.AppToken));
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {
                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null) {

                    if (response.body().responseCode.equalsIgnoreCase("200")) {
                        homeItemsModelList.clear();
                        if (response.body().allServiceList != null && response.body().allServiceList.size() > 0) {
                            homeItemsModelList.addAll(response.body().allServiceList);
                            homeItemsAdapter.notifyDataSetChanged();

                        } else {
                            Toast.makeText(context, response.body().responseMessage, Toast.LENGTH_SHORT).show();
                        }
                    } else {
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
                t.printStackTrace();
            }
        });
    }

    private void setRecycler() {
        homeItemsAdapter = new HomeItemsAdapter(context,homeItemsModelList);
        RecyclerView.LayoutManager mLayoutManager = new LinearLayoutManager(context,LinearLayoutManager.HORIZONTAL,false);
        rvHomeItems.setLayoutManager(mLayoutManager);
        rvHomeItems.setAdapter(homeItemsAdapter);
    }

    private void getIds() {
        ivRestaurantImage= (ImageView) findViewById(R.id.ivRestaurantImage);
        rvHomeItems= (RecyclerView) findViewById(R.id.rvHomeItems);
        tvTime =(TextView) findViewById(R.id.tvTime);
        tvDayDate =(TextView) findViewById(R.id.tvDayDate);
        tvDayDate.setText(CommonUtils.getDateAndTimeFromTimeStamp(System.currentTimeMillis()));
        tvTime.setText(CommonUtils.getTimeFromTimeStamp(System.currentTimeMillis()));
    }

    /*=============================================Location============================================*/
    private void checkPermission() {
        if (CommonUtils.checkPermissionGPS(NewHomeScreenActivity.this)) {

            if (!locationManager.isProviderEnabled(LocationManager.GPS_PROVIDER)) {
                enableLoc();

            } else {
                Log.e("logEnabled","Location already enabled");
            }
        } else {
            CommonUtils.requestPermissionGPS(NewHomeScreenActivity.this);
        }
    }

    private void enableLoc() {

        GoogleApiClient googleApiClient = new GoogleApiClient.Builder(this)
                .addApi(LocationServices.API)
                .addConnectionCallbacks(this)
                .addOnConnectionFailedListener(new GoogleApiClient.OnConnectionFailedListener() {
                    @Override
                    public void onConnectionFailed(@NonNull ConnectionResult connectionResult) {

                    }
                }).build();
        googleApiClient.connect();

        LocationRequest locationRequest = LocationRequest.create();
        locationRequest.setPriority(LocationRequest.PRIORITY_HIGH_ACCURACY);
        locationRequest.setInterval(30 * 1000);
        locationRequest.setFastestInterval(5 * 1000);
        LocationSettingsRequest.Builder builder = new LocationSettingsRequest.Builder()
                .addLocationRequest(locationRequest);
        builder.setAlwaysShow(true);


        PendingResult<LocationSettingsResult> result =
                LocationServices.SettingsApi.checkLocationSettings(googleApiClient, builder.build());
        result.setResultCallback(new ResultCallback<LocationSettingsResult>() {
            @Override
            public void onResult(LocationSettingsResult result) {
                final Status status = result.getStatus();
                switch (status.getStatusCode()) {


                    case LocationSettingsStatusCodes.RESOLUTION_REQUIRED:
                        try {
                            // Show the dialog by calling startResolutionForResult(),
                            // and check the result in onActivityResult().
                            status.startResolutionForResult(
                                    (Activity) context, REQUEST_LOCATION);

                        } catch (IntentSender.SendIntentException e) {
                            // Ignore the error.
                        }
                        break;
                }
            }
        });
    }


    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String permissions[], @NonNull int[] grantResults) {
        switch (requestCode) {

            case AppConstant.PERMISSION_REQUEST_GPS_CODE:
                if (grantResults.length > 0 && grantResults[0] == PackageManager.PERMISSION_GRANTED) {


                    if (!locationManager.isProviderEnabled(LocationManager.GPS_PROVIDER)) {
                        enableLoc();
                    } else {
                        intent=new Intent(context, BestRestaurantNearCity.class);
                        intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                        startActivity(intent);
                    }
                } else {
                    Toast.makeText(getApplicationContext(), R.string.permission_denied_you_can_not_access_location_data, Toast.LENGTH_LONG).show();

                }
                break;

        }
    }

    @Override
    public void onConnected(@Nullable Bundle bundle) {

    }

    @Override
    public void onConnectionSuspended(int i) {

    }

    @Override
    public void gotLocation(Location location) {

    }
}
