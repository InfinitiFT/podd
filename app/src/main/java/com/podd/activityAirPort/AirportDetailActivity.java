package com.podd.activityAirPort;

import android.app.Activity;
import android.app.DatePickerDialog;
import android.content.Context;
import android.content.Intent;
import android.graphics.Typeface;
import android.location.Location;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.widget.CheckBox;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.common.GoogleApiAvailability;
import com.google.android.gms.common.GooglePlayServicesNotAvailableException;
import com.google.android.gms.common.GooglePlayServicesRepairableException;
import com.google.android.gms.common.api.Status;
import com.google.android.gms.location.places.Place;
import com.google.android.gms.location.places.ui.PlaceAutocomplete;
import com.podd.R;
import com.podd.activityRestaurant.SearchableListDialog;
import com.podd.activityRestaurant.SearchableLocationListDialog;
import com.podd.location.LocationResult;
import com.podd.location.LocationTracker;
import com.podd.retrofit.ApiClient;
import com.podd.retrofit.ApiInterface;
import com.podd.utils.AppConstant;
import com.podd.utils.CommonUtils;
import com.podd.utils.Logger;
import com.podd.utils.SetTimerClass;
import com.podd.webservices.JsonResponse;
import java.text.SimpleDateFormat;
import java.util.Arrays;
import java.util.Calendar;
import java.util.Locale;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
/**
 * Created by Raj Kumar on 3/7/2017
 * for Mobiloitte
 */

public class AirportDetailActivity extends AppCompatActivity implements View.OnClickListener,SearchableListDialog.SearchableItem ,SearchableLocationListDialog.SearchableItem{
    private Context mContext=AirportDetailActivity.this;
    private final String TAG = AirportDetailActivity.class.getSimpleName();
    private TextView tvMsg,tvDate,tvBagNumber,tvTime,tvSubmit,tvTimeFormate,tvHeader,tvSelectDelivery,tvPickUp;
    private EditText etName,etPhoneNumber;
    private CheckBox cbTermsConditions;
    private String date;
    private SearchableListDialog _searchableListDialog;
    private final String[] numberOfBagArray = {/*"Number of bag",*/ "1", "2", "3", "4", "5", "6", "7", "8", "9", "10"};
    private final String[] delivery_airport = {"London City Airport", "London Gatwick Airport", "London Heathrow Airport"};
    private final String[] timeSlot = {/*"Number of bag",*/ "9 AM", "9.30 AM", "10 AM","10.30 AM","11 AM","11.30 AM","12 PM","12.30 PM","1 PM",
            "1.30 PM","2 PM","2.30 PM","3 PM","3.30 PM","4 PM","4.30 PM","5 PM"};
    private String selectedItem = "";
    private LinearLayout llTime;
    private String currentLat = "";
    private String currentLog = "";
    private String currentAddress="";
    private SetTimerClass setTimerClass;

    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_airport_detail);
       mContext=AirportDetailActivity.this;
        getID();
        setFont();
        setListeners();
        fetchLocation();
        setTimerClass = (SetTimerClass)getApplication();
    }
    private void getID() {
        tvHeader=(TextView)findViewById(R.id.tvHeader);
        tvMsg=(TextView)findViewById(R.id.tvMsg);
        etName=(EditText)findViewById(R.id.etName);
        tvDate=(TextView)findViewById(R.id.tvDate);
        tvBagNumber=(TextView)findViewById(R.id.tvBagNumber);
        tvPickUp=(TextView)findViewById(R.id.tvPickUp);
        tvSelectDelivery=(TextView)findViewById(R.id.tvSelectDelivery);
        etPhoneNumber=(EditText)findViewById(R.id.etPhoneNumber);
        tvTime=(TextView)findViewById(R.id.tvTime);
        tvSubmit=(TextView)findViewById(R.id.tvSubmit);
        tvTimeFormate=(TextView)findViewById(R.id.tvTimeFormate);
        cbTermsConditions=(CheckBox)findViewById(R.id.cbTermsConditions);
        llTime=(LinearLayout)findViewById(R.id.llTime);

    }
    private void setFont() {
        Typeface typeface = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Regular.ttf");
        Typeface typefaceBold = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Bold.ttf");
        tvHeader.setTypeface(typefaceBold);
        tvSubmit.setTypeface(typefaceBold);
        tvMsg.setTypeface(typeface);
        etName.setTypeface(typeface);
        tvDate.setTypeface(typeface);
        tvBagNumber.setTypeface(typeface);
        tvPickUp.setTypeface(typeface);
        tvSelectDelivery.setTypeface(typeface);
        etPhoneNumber.setTypeface(typeface);
        tvTime.setTypeface(typeface);
        cbTermsConditions.setTypeface(typeface);
        tvTimeFormate.setTypeface(typeface);
    }
    private void setListeners() {
        tvDate.setOnClickListener(this);
        tvBagNumber.setOnClickListener(this);
        tvSubmit.setOnClickListener(this);
        tvTime.setOnClickListener(this);
        llTime.setOnClickListener(this);
        tvSelectDelivery.setOnClickListener(this);
        tvPickUp.setOnClickListener(this);
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.tvDate:
                pickDate();
                break;
            case R.id.tvBagNumber:
                BagNumber();
                break;
            case R.id.llTime:
                timeFormate();
                break;
            case R.id.tvSelectDelivery:
                deliveryAirprot();
                break;
            case R.id.tvSubmit:
               if(isValid()){
                   startActivity(new Intent(mContext,AirportSummeryActivity.class));
               }
                break;
            case R.id.tvPickUp:
                openAutocompleteActivity(100);
                break;
        }

    }
    private boolean isValid() {
        if (etName.getText().toString().trim().equalsIgnoreCase("")) {
            Toast.makeText(mContext, "Please enter name.", Toast.LENGTH_LONG).show();
            return false;
        } else if (tvDate.getText().toString().trim().matches(getString(R.string.date_of_travel))) {
            Toast.makeText(mContext, R.string.please_select_a_valid_time, Toast.LENGTH_LONG).show();
            return false;
        } else if (tvBagNumber.getText().toString().trim().matches(getString(R.string.number_of_bags))) {
            Toast.makeText(mContext, R.string.please_select_number_of_bag, Toast.LENGTH_LONG).show();
            return false;
        } else if (tvPickUp.getText().toString().trim().equalsIgnoreCase("")) {
            Toast.makeText(mContext, "Please enter pick up location.", Toast.LENGTH_LONG).show();
            return false;
        } else if (tvSelectDelivery.getText().toString().trim().equalsIgnoreCase("")) {
            Toast.makeText(mContext, "Please select delivery airport.", Toast.LENGTH_LONG).show();
            return false;
        }else if (etPhoneNumber.getText().toString().trim().equalsIgnoreCase("")) {
            Toast.makeText(mContext, "Please enter telephone number.", Toast.LENGTH_LONG).show();
            return false;
        }else if (tvTime.getText().toString().trim().equalsIgnoreCase("")) {
            Toast.makeText(mContext, "Please select time.", Toast.LENGTH_LONG).show();
            return false;
        }else if(!cbTermsConditions.isChecked()){
            Toast.makeText(mContext, R.string.agree_to_call_back, Toast.LENGTH_LONG).show();
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
        }
        catch (GooglePlayServicesNotAvailableException e) {
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
                tvPickUp.setText(currentAddress);


            } else if (resultCode == PlaceAutocomplete.RESULT_ERROR) {
                Status status = PlaceAutocomplete.getStatus(mContext, data);
                Log.e(TAG, "Error: Status = " + status.toString());
            } else if (resultCode == RESULT_CANCELED) {
            }
        }
    }

    private void BagNumber() {
        _searchableListDialog = SearchableListDialog.newInstance(Arrays.asList(numberOfBagArray));
        selectedItem = "number_of_bag";
        _searchableListDialog.setOnSearchableItemClickListener(AirportDetailActivity.this);
        _searchableListDialog.show(getFragmentManager(), TAG);
        _searchableListDialog.setTitle(getString(R.string.select));
    } private void timeFormate() {
        _searchableListDialog = SearchableListDialog.newInstance(Arrays.asList(timeSlot));
        selectedItem = "time_formate";
        _searchableListDialog.setOnSearchableItemClickListener(AirportDetailActivity.this);
        _searchableListDialog.show(getFragmentManager(), TAG);
        _searchableListDialog.setTitle(getString(R.string.select));
    }private void deliveryAirprot() {
        _searchableListDialog = SearchableListDialog.newInstance(Arrays.asList(delivery_airport));
        selectedItem = "delivery_airport";
        _searchableListDialog.setOnSearchableItemClickListener(AirportDetailActivity.this);
        _searchableListDialog.show(getFragmentManager(), TAG);
        _searchableListDialog.setTitle(getString(R.string.select));
    }


    private void pickDate() {
        final Calendar calendar = Calendar.getInstance();
        int cYear = calendar.get(Calendar.YEAR);
        final int cMonth = calendar.get(Calendar.MONTH);
        final int cDay = calendar.get(Calendar.DAY_OF_MONTH);

        DatePickerDialog dpd = new DatePickerDialog(mContext, new DatePickerDialog.OnDateSetListener() {

            @Override
            public void onDateSet(DatePicker view, int year, int monthOfYear, int dayOfMonth) {
                calendar.set(year, monthOfYear, dayOfMonth);
                SimpleDateFormat simpleDateFormat = new SimpleDateFormat("dd-MM-yyyy", Locale.getDefault());
                date = simpleDateFormat.format(calendar.getTime());
                tvDate.setText(date);
            }
        }, cYear, cMonth, cDay);
        DatePicker dp = dpd.getDatePicker();
        if (date != null) {
            dpd.getDatePicker().updateDate(CommonUtils.getPreferencesInt(mContext, AppConstant.YEAR), CommonUtils.getPreferencesInt(mContext, AppConstant.MONTH), CommonUtils.getPreferencesInt(mContext, AppConstant.DATE));
        } else {
            dp.setMaxDate(Calendar.getInstance().getTimeInMillis());
        }
        dpd.show();
        dpd.getDatePicker().setMinDate(System.currentTimeMillis()-1000);
        dpd.getDatePicker().setMaxDate(System.nanoTime());
        dpd.setCancelable(true);
    }
    @Override
    public void onSearchableItemClicked(Object item, int position) {

        switch (selectedItem) {

            case "number_of_bag":
                tvBagNumber.setText(item.toString().trim());
                tvBagNumber.setText(tvBagNumber.getText().toString().trim());
                break;
            case "time_formate":
                tvTime.setText(item.toString().trim());
                tvTime.setText(tvTime.getText().toString().trim());
                tvTimeFormate.setVisibility(View.GONE);
                break;
            case "delivery_airport":
                tvSelectDelivery.setText(item.toString().trim());
                tvSelectDelivery.setText(tvSelectDelivery.getText().toString().trim());

                break;
        }
    }
    private void fetchLocation() {
        new LocationTracker(mContext, new LocationResult() {
            @Override
            public void gotLocation(Location location) {
                currentLat = String.valueOf(location.getLatitude());
                currentLog = String.valueOf(location.getLongitude());
                if (CommonUtils.isNetworkConnected(AirportDetailActivity.this)) {
                    getAddressFromPlaceApi(String.valueOf(currentLat), String.valueOf(currentLog));
                } else {
                    Toast.makeText(AirportDetailActivity.this, getString(R.string.server_not_responding), Toast.LENGTH_SHORT).show();
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
                    tvPickUp.setText(response.body().results.get(0).formatted_address);

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
