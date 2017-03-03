package com.podd.activityTaxi;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.graphics.Typeface;
import android.location.Location;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v7.app.AppCompatActivity;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.common.GoogleApiAvailability;
import com.google.android.gms.common.GooglePlayServicesNotAvailableException;
import com.google.android.gms.common.GooglePlayServicesRepairableException;
import com.google.android.gms.common.api.Status;
import com.google.android.gms.location.places.Place;
import com.google.android.gms.location.places.ui.PlaceAutocomplete;
import com.google.gson.Gson;
import com.podd.R;
import com.podd.hailoTaxi.HailoDrivers;
import com.podd.hailoTaxi.HailoETA;
import com.podd.hailoTaxi.HailoResponse;
import com.podd.hailoTaxi.ListViewModel;
import com.podd.hailoTaxi.TaxiServiceAsync;
import com.podd.hailoTaxi.TaxiWebServiceStatus;
import com.podd.location.LocationResult;
import com.podd.location.LocationTracker;
import com.podd.retrofit.ApiClient;
import com.podd.retrofit.ApiInterface;
import com.podd.utils.AppConstant;
import com.podd.utils.CommonUtils;
import com.podd.utils.Logger;
import com.podd.utils.SetTimerClass;
import com.podd.webservices.JsonResponse;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;


public class HailoActivity extends AppCompatActivity implements View.OnClickListener {
    private static final int REQUEST_CODE_AUTOCOMPLETE = 1;
    private TextView tvSourceAddress, tvEndAddress, tvEta,tvMsg,tvHeader;
    private Button btnBookNow, btnGetEta;
    private String TAG = HailoActivity.class.getSimpleName();
    private Context mContext = HailoActivity.this;
    private String currentLat = "";
    private String currentLog = "";
    private String destinationLat = "";
    private String destinationLog = "";
    private String currentAddress="";
    private String destinationAddress="";
    private SetTimerClass setTimerClass;

    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_hailo);
        getID();
        setListener();
        fetchLocation();
        setFont();
        setTimerClass = (SetTimerClass)getApplication();
    }
    private void setFont() {
        Typeface typeface = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Regular.ttf");
        tvSourceAddress.setTypeface(typeface);
        tvEndAddress.setTypeface(typeface);
        tvEta.setTypeface(typeface);
        tvMsg.setTypeface(typeface);

        Typeface typefaceBold = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Bold.ttf");
        btnGetEta.setTypeface(typefaceBold);
        btnBookNow.setTypeface(typefaceBold);
        tvHeader.setTypeface(typefaceBold);

    }
    private void fetchLocation() {
        new LocationTracker(mContext, new LocationResult() {
            @Override
            public void gotLocation(Location location) {
                currentLat = String.valueOf(location.getLatitude());
                currentLog = String.valueOf(location.getLongitude());
                if (CommonUtils.isNetworkConnected(HailoActivity.this)) {
                    getAddressFromPlaceApi(String.valueOf(currentLat), String.valueOf(currentLog));
                } else {
                    Toast.makeText(HailoActivity.this, getString(R.string.server_not_responding), Toast.LENGTH_SHORT).show();
                }

            }
        }).onUpdateLocation();
    }

    private void getAddressFromPlaceApi(String currLat, String currLong) {
        CommonUtils.showProgressDialog(mContext);
        ApiInterface apiServices = ApiClient.getClient(this).create(ApiInterface.class);
        String latLong = currLat + "," + currLong;
        Call<JsonResponse> call = apiServices.getPlaceApi(latLong);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {
                CommonUtils.disMissProgressDialog(mContext);
                /*tvCityName.setText(response.body().results.get(0).formatted_address);*/
           if(response.body().results.get(0).formatted_address!=null&&response.body().results.get(0).formatted_address.length()>0)
                tvSourceAddress.setText(response.body().results.get(0).formatted_address);

        }

            @Override
            public void onFailure(Call<JsonResponse> call, Throwable t) {
                CommonUtils.disMissProgressDialog(mContext);
                Logger.addRecordToLog("Exception :" + t.getMessage());
                CommonUtils.disMissProgressDialog(mContext);
                Log.e(TAG, t.toString());
            }
        });
    }


    private void getID() {
        tvMsg = (TextView) findViewById(R.id.tvMsg);
        tvSourceAddress = (TextView) findViewById(R.id.tvSourceAddress);
        tvEndAddress = (TextView) findViewById(R.id.tvEndAddress);
        tvHeader = (TextView) findViewById(R.id.tvHeader);
        tvEta = (TextView) findViewById(R.id.tvEta);
        btnGetEta = (Button) findViewById(R.id.btnGetEta);
        btnBookNow = (Button) findViewById(R.id.btnBookNow);

    }
    private void setListener() {
        tvSourceAddress.setOnClickListener(this);
        tvEndAddress.setOnClickListener(this);
        btnBookNow.setOnClickListener(this);
        btnGetEta.setOnClickListener(this);
    }

    @Override
    public void onClick(View v) {
        switch (v.getId()) {
            case R.id.tvSourceAddress:
                openAutocompleteActivity(100);
                break;
            case R.id.tvEndAddress:
                openAutocompleteActivity(200);
                break;
            case R.id.btnGetEta:
                if (isValid()) {

                    if (CommonUtils.isNetworkConnected(mContext)) {
                        callHailoETAApi(currentLat, currentLog);
                    } else {
                        Toast.makeText(mContext, R.string.Please_connect_to_internet_first, Toast.LENGTH_SHORT).show();
                    }
                }

                break;
            case R.id.btnBookNow:
                if (isValidation()) {
                    if (CommonUtils.isNetworkConnected(mContext)) {
                        callBookNow(currentLat, currentLog,destinationLat,destinationLog ,currentAddress,destinationAddress);
                    } else {
                        Toast.makeText(mContext, R.string.Please_connect_to_internet_first, Toast.LENGTH_SHORT).show();
                    }
                }
                break;
        }

    }

    private void callBookNow(String currentLat, String currentLog,String destinationLat,String destinationLog,
                             String currentAddress,String destinationAddress) {
        DeepLinking.openHailoApp(mContext, currentLat, currentLog, currentAddress,
                destinationLat, destinationLog, destinationAddress, Tokens.HAILO_TOKEN);

    }

    private boolean isValid() {
        if (tvSourceAddress.getText().toString().isEmpty()) {
            Toast.makeText(mContext, "Please enter current location", Toast.LENGTH_SHORT).show();
            tvSourceAddress.requestFocus();
            return false;
        }

        return true;
    }

    private boolean isValidation() {
        if (tvSourceAddress.getText().toString().isEmpty()) {
            Toast.makeText(mContext, "Please enter current location", Toast.LENGTH_SHORT).show();
            tvSourceAddress.requestFocus();
            return false;
        } else if (tvEndAddress.getText().toString().isEmpty()) {
            Toast.makeText(mContext, "Please enter destination location", Toast.LENGTH_SHORT).show();
            tvEndAddress.requestFocus();
            return false;
        }

        return true;
    }
    /*Google place api for search location*/
    private void openAutocompleteActivity(int requestCode) {
        try {
            Intent intent = new PlaceAutocomplete.IntentBuilder(PlaceAutocomplete.MODE_OVERLAY)
                    .build((Activity) mContext);
            startActivityForResult(intent, requestCode);
        } catch (GooglePlayServicesRepairableException e) {
            GoogleApiAvailability.getInstance().getErrorDialog(this, e.getConnectionStatusCode(), 0).show();
        } catch (GooglePlayServicesNotAvailableException e) {
            String message = "Google Play Services is not available: " + GoogleApiAvailability.getInstance().getErrorString(e.errorCode);
            Log.e(TAG, message);
            Toast.makeText(mContext, message, Toast.LENGTH_SHORT).show();
        }
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        if (requestCode == 100) {
            if (resultCode == RESULT_OK) {
                Place place = PlaceAutocomplete.getPlace(mContext, data);
                Log.i(TAG, "Place Selected: " + place.getName());

                currentLat = String.valueOf(place.getLatLng().latitude);
                currentLog = String.valueOf(place.getLatLng().longitude);
                currentAddress= String.valueOf(place.getName());
                tvSourceAddress.setText(currentAddress);


            } else if (resultCode == PlaceAutocomplete.RESULT_ERROR) {
                Status status = PlaceAutocomplete.getStatus(mContext, data);
                Log.e(TAG, "Error: Status = " + status.toString());
            } else if (resultCode == RESULT_CANCELED) {
            }
        } else if (requestCode == 200) {
            if (resultCode == RESULT_OK) {
                Place place = PlaceAutocomplete.getPlace(mContext, data);
                Log.i(TAG, "Place Selected: " + place.getName());
                destinationLat = String.valueOf(place.getLatLng().latitude);
                destinationLog = String.valueOf(place.getLatLng().longitude);
                destinationAddress= String.valueOf(place.getName());
                tvEndAddress.setText(destinationAddress);
            } else if (resultCode == PlaceAutocomplete.RESULT_ERROR) {
                Status status = PlaceAutocomplete.getStatus(mContext, data);
                Log.e(TAG, "Error: Status = " + status.toString());
            } else if (resultCode == RESULT_CANCELED) {
            }

        }
    }

    /**
     * This method calls the Hailo App API to find the near by drivers.
     */
    private void callHailoETAApi(String currentLat, String currentLng) {
        /*s*/
       /* String currentLat="51.507861";
        String currentLng="0.127356";*/
        String address = "Landon,UK";
        CommonUtils.showProgressDialog(mContext);
        String TOKEN = "E8bEVhHFo7WTrpIgQ9jpSSTaFqzEuqRKVSIh3di7zGKQ5rhZj2UK4ndxwZ4mEKEQgvDF8b/c/rCzwBh4TR6iqUwOhenf5WQSORivTXU6ECtGSSNmMMFK6jmskN8D3QGlRYevARFK+ZJ+luvx7Xz87NO/IGJ45Fte4btUBavPZAfr3CX9UNf5jlr9/DclvjtIykE9UCn3hqsXga/I6FIsAw==";
        String url = "https://api.hailoapp.com/drivers/eta?latitude=" + currentLat + "&longitude=" + currentLng;

        TaxiServiceAsync taxiServiceAsync = new TaxiServiceAsync(mContext, "", url, "GET", false, TOKEN, "Authorization",
                "token", new TaxiWebServiceStatus() {
            @Override
            public void onSuccess(Object o) {
                HailoResponse serviceResponse = new Gson().fromJson(o.toString(), HailoResponse.class);
                if (serviceResponse != null) {

                    if (serviceResponse.etas != null && serviceResponse.etas.size() > 0) {
                        for (HailoETA hailoETA : serviceResponse.etas) {
                            try {
                                for (int i = 0; i < Integer.valueOf(hailoETA.count); i++) {
                                    ListViewModel listViewModel = new ListViewModel();
                                    listViewModel.eta = hailoETA.eta;
                                    listViewModel.taxiType = hailoETA.service_type;
                                    listViewModel.taxiServiceName = AppConstant.HAILO_TAXI;
                                }
                                tvEta.setText("Your driver will arrive in " + serviceResponse.etas.get(0).eta + " minutes");

                            } catch (NumberFormatException e) {
                                e.printStackTrace();
                            }
                        }
                    } else if (serviceResponse.error != null && !TextUtils.isEmpty(serviceResponse.error.description)) {
                        CommonUtils.showToast(mContext, serviceResponse.error.description);
                    }
                } else {

                }
            }
            @Override
            public void onFailed(int code) {

                if (code == 400) {
                    CommonUtils.showToast(mContext, "Hailo not available at this location.");
                } else {
                }

            }
        });
        taxiServiceAsync.execute("");
    }



    /**
     * This method calls the Hailo App API to find the near by drivers.
     */
    private void callHailoDriver() {

        /*s*/
        String currentLat="51.507861";
        String currentLng="0.127356";
        CommonUtils.showProgressDialog(mContext);
        String TOKEN = "E8bEVhHFo7WTrpIgQ9jpSSTaFqzEuqRKVSIh3di7zGKQ5rhZj2UK4ndxwZ4mEKEQgvDF8b/c/rCzwBh4TR6iqUwOhenf5WQSORivTXU6ECtGSSNmMMFK6jmskN8D3QGlRYevARFK+ZJ+luvx7Xz87NO/IGJ45Fte4btUBavPZAfr3CX9UNf5jlr9/DclvjtIykE9UCn3hqsXga/I6FIsAw==";
        String url = "https://api.hailoapp.com/drivers/near?latitude=" + currentLat + "&longitude=" + currentLng;

        TaxiServiceAsync taxiServiceAsync = new TaxiServiceAsync(mContext, "", url, "GET", false, TOKEN, "Authorization",
                "token", new TaxiWebServiceStatus() {
            @Override
            public void onSuccess(Object o) {
                HailoResponse serviceResponse = new Gson().fromJson(o.toString(), HailoResponse.class);
                if (serviceResponse != null) {

                    if (serviceResponse.drivers != null && serviceResponse.drivers.size() > 0) {
                        for (HailoDrivers hailoDrivers : serviceResponse.drivers) {

                        }
                    } else if (serviceResponse.error != null && !TextUtils.isEmpty(serviceResponse.error.description)) {
                        CommonUtils.showToast(mContext, serviceResponse.error.description);
                    }
                } else {

                }
            }

            @Override
            public void onFailed(int code) {

                if (code == 400) {
                    CommonUtils.showToast(mContext, "Hailo not available at this location.");
                } else {
                }

            }
        });
        taxiServiceAsync.execute("");
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
