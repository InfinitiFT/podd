package com.podd.activityRestaurant;


import android.app.Dialog;
import android.content.Context;
import android.content.Intent;
import android.graphics.Typeface;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;
import com.google.gson.Gson;
import com.podd.R;
import com.podd.model.CountryCodeModel;
import com.podd.retrofit.ApiClient;
import com.podd.retrofit.ApiInterface;
import com.podd.utils.AppConstant;
import com.podd.utils.CommonUtils;
import com.podd.utils.DialogUtils;
import com.podd.webservices.JsonRequest;
import com.podd.webservices.JsonResponse;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;


public class BookingSummaryActivity extends AppCompatActivity implements View.OnClickListener {
    private Intent intent;
    private Context context;
    private EditText etName;
    private Spinner spCountryCode;
    private EditText etPhoneNumber;
    private EditText etEmail;
    private TextView tvCompleteBooking;
    private TextView tvRestaurantName;
    private TextView tvLocation,tvLocationLeft;
    private TextView tvDateBooked,tvDateBookedLeft;
    private TextView tvTimeBooked,tvTimeBookedLeft;
    private TextView tvNumberofPeople,tvNoOfPeopleLeft,tvBookTaxi,tvConfirmation;

    private Dialog dialogConfirmBooking;
    private EditText etEnterOtp;
    private String location;
    private String dateBooked;
    private String timeBooked;
    private String noOfPersons;
    private String restaurantName;
    private String restaurantId;
    private final String TAG=BookingSummaryActivity.class.getSimpleName();
    private String email;
    private String phone;
    private String otp;
    private List<String> countryCodeList;
   // private final String[]countryCodeArray={"+93","+91","+358","+355","+213","+1684","+376","+244","+1264","+1268","+54","+374","+297","+61","+43","+994","+1242","+973","+880","+1246","+375","+32","+501","+229","+1441","+975","+591","+5997","+387","+267","+55","+246","+1284","+1 340","+673","+359","+226","+257","+855","+237","+1","+238","+1345","+236","+235","+56","+86","+61","+57","+269","+242","+243","+682","+506","+385","+53","+599","+357","+420","+45","+253","+1767","+1809","+1849","+1829","+593","+503","+240","+291","+372","+251","+500","+298","+679","+358","+33","+594","+689","+241","+220","+995","+49","+233","+350","+299","+1473","+590","+1671","+502","+44","+224","+245","+592","+509","+379","+504"};
    private String countryCode;
    private boolean isnativecountryselected;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_booking_summary);
        context = BookingSummaryActivity.this;

        getIds();
        setListeners();
        setFont();
        //setSpinner();
        etName.requestFocus();
        if(getIntent()!=null) {
            restaurantName = getIntent().getStringExtra(AppConstant.RESTAURANTNAME);
            location = getIntent().getStringExtra(AppConstant.LOCATION);
            dateBooked = getIntent().getStringExtra(AppConstant.DATEBOOKED);
            timeBooked = getIntent().getStringExtra(AppConstant.TIMEBOOKED);
            noOfPersons = getIntent().getStringExtra(AppConstant.NOOFPEOPLE);
            restaurantId = getIntent().getStringExtra(AppConstant.RESTAURANTID);

            tvRestaurantName.setText(restaurantName);
            tvLocation.setText(location);
            tvDateBooked.setText(dateBooked);
            tvTimeBooked.setText(timeBooked);
            tvNumberofPeople.setText(noOfPersons);
        }

        if(CommonUtils.isNetworkConnected(this)){
            callCountryCode();
        }else {
            CommonUtils.showAlertOk(getString(R.string.Please_connect_to_internet_first),BookingSummaryActivity.this);
        }

        spCountryCode.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {

                countryCode="";
                countryCode = countryCodeList.get(position);
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });

    }

    private void callCountryCode() {
        CommonUtils.showProgressDialog(context);
        ApiInterface apiServices = ApiClient.getClient(this).create(ApiInterface.class);

        Call<List<CountryCodeModel> >call = apiServices.getCountryCodeApi();
        call.enqueue(new Callback<List<CountryCodeModel>>() {
            @Override
            public void onResponse(Call<List<CountryCodeModel>> call, Response<List<CountryCodeModel>> response) {
                countryCodeList= new ArrayList<>();
                CommonUtils.disMissProgressDialog(context);
                countryCodeList.clear();
                spCountryCode.setPrompt(getString(R.string.country_code));
                for (int i = 0; i < response.body().size(); i++) {
                    countryCodeList.addAll(response.body().get(i).callingCodes);
                }

                ArrayAdapter<String> adapter=new ArrayAdapter<>(context,R.layout.row_textview_spinner_type,countryCodeList);
                adapter.setDropDownViewResource(R.layout.row_report_type_dropdown);
                spCountryCode.setAdapter(adapter);
            }

            @Override
            public void onFailure(Call<List<CountryCodeModel>> call, Throwable t) {
                CommonUtils.disMissProgressDialog(context);
                Log.e(TAG, t.toString());
            }
        });

    }

    /*private void setSpinner() {
        ArrayAdapter<String> adapter=new ArrayAdapter<>(context,R.layout.row_textview_spinner_type,countryCodeList);
        adapter.setDropDownViewResource(R.layout.row_report_type_dropdown);
        spCountryCode.setAdapter(adapter);

    }*/

    private void getIds() {
        tvCompleteBooking = (TextView) findViewById(R.id.tvCompleteBooking);
        tvBookTaxi = (TextView) findViewById(R.id.tvBookTaxi);
        etName = (EditText) findViewById(R.id.etName);
        spCountryCode = (Spinner) findViewById(R.id.spCountryCode);
        etPhoneNumber = (EditText) findViewById(R.id.etPhoneNumber);
        etEmail = (EditText) findViewById(R.id.etEmail);
        tvRestaurantName = (TextView) findViewById(R.id.tvRestaurantName);
        tvLocation = (TextView) findViewById(R.id.tvLocation);
        tvDateBooked = (TextView) findViewById(R.id.tvDateBooked);
        tvTimeBooked = (TextView) findViewById(R.id.tvTimeBooked);
        tvNumberofPeople = (TextView) findViewById(R.id.tvNumberofPeople);
        tvConfirmation = (TextView) findViewById(R.id.tvConfirmation);
        tvLocationLeft = (TextView) findViewById(R.id.tvLocationLeft);
        tvDateBookedLeft = (TextView) findViewById(R.id.tvDateBookedLeft);
        tvTimeBookedLeft = (TextView) findViewById(R.id.tvTimeBookedLeft);
        tvNoOfPeopleLeft = (TextView) findViewById(R.id.tvNoOfPeopleLeft);
    }

    private void setFont() {
        Typeface typefaceBold = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Bold.ttf");
        Typeface typefaceRegular = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Regular.ttf");
        tvRestaurantName.setTypeface(typefaceBold);
        tvBookTaxi.setTypeface(typefaceBold);
        tvLocationLeft.setTypeface(typefaceRegular);
        tvLocation.setTypeface(typefaceRegular);
        tvDateBookedLeft.setTypeface(typefaceRegular);
        tvDateBooked.setTypeface(typefaceRegular);
        tvTimeBookedLeft.setTypeface(typefaceRegular);
        tvTimeBooked.setTypeface(typefaceRegular);
        tvNoOfPeopleLeft.setTypeface(typefaceRegular);
        tvNumberofPeople.setTypeface(typefaceRegular);
        tvConfirmation.setTypeface(typefaceRegular);
        etName.setTypeface(typefaceRegular);
        etPhoneNumber.setTypeface(typefaceRegular);
        etEmail.setTypeface(typefaceRegular);

    }

    private void setListeners() {
        tvCompleteBooking.setOnClickListener(this);
       // spCountryCode.setOnItemSelectedListener(this);
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()) {
            case R.id.tvCompleteBooking:
                CommonUtils.hideKeyboard(BookingSummaryActivity.this);
                if (isValid()) {
                    sendOtpApi();
                    /*name=etName.getText().toString().trim();
                    phone=etPhoneNumber.getText().toString().trim();
                    email=etEmail.getText().toString().trim();*/
                    break;
                }
                break;

        }
    }

    private void showOtpDialog() {
        dialogConfirmBooking = DialogUtils.createCustomDialog(context, R.layout.dialog_booking_confirmation);

        TextView tvSubmit = (TextView) dialogConfirmBooking.findViewById(R.id.tvSubmit);
        TextView tvEnterYourEmailId = (TextView) dialogConfirmBooking.findViewById(R.id.tvEnterYourEmailId);
        TextView tvResendOtp = (TextView) dialogConfirmBooking.findViewById(R.id.tvResendOtp);
        etEnterOtp = (EditText) dialogConfirmBooking.findViewById(R.id.etEnterOtp);
        Typeface typefaceBold = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Bold.ttf");
        tvEnterYourEmailId.setTypeface(typefaceBold);
        tvSubmit.setTypeface(typefaceBold);
        tvResendOtp.setTypeface(typefaceBold);
        Typeface typefaceRegular = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Regular.ttf");
        etEnterOtp.setTypeface(typefaceRegular);

        tvSubmit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(isValidOtp()) {
                    otp=etEnterOtp.getText().toString().trim();
                    otpVerificationApi();

                }
            }
        });

        tvResendOtp.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                resendOtpService();

            }
        });

        dialogConfirmBooking.show();
    }

    private boolean isValidOtp() {
        if (etEnterOtp.getText().toString().trim().isEmpty()) {
            Toast.makeText(context, R.string.please_enter_otp, Toast.LENGTH_SHORT).show();
            return false;
        } else if (etEnterOtp.getText().toString().trim().length() <= 3) {
            Toast.makeText(context, R.string.please_enter_valid_otp, Toast.LENGTH_SHORT).show();
            return false;
        }
        return true;
    }


    private boolean isValid() {
        String EMAIL_PATTERN = "^[_A-Za-z0-9-]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$";
        if (etName.getText().toString().trim().isEmpty()) {
            Toast.makeText(context, R.string.please_enter_name, Toast.LENGTH_LONG).show();
            etName.requestFocus();
            return false;
        }else if (etName.getText().toString().trim().length()<3) {
            Toast.makeText(context, R.string.name_must_be_more_than, Toast.LENGTH_LONG).show();
            etPhoneNumber.requestFocus();
            return false;
        } else if (etPhoneNumber.getText().toString().trim().isEmpty()) {
            Toast.makeText(context, R.string.please_enter_phone_number, Toast.LENGTH_LONG).show();
            etPhoneNumber.requestFocus();
            return false;
        }else if (etPhoneNumber.getText().toString().trim().equalsIgnoreCase("0000000000")||etPhoneNumber.getText().toString().trim().equalsIgnoreCase("00000000000")|| etPhoneNumber.getText().toString().trim().equalsIgnoreCase("000000000000")|| etPhoneNumber.getText().toString().trim().equalsIgnoreCase("0000000000000")|| etPhoneNumber.getText().toString().trim().equalsIgnoreCase("00000000000000")||etPhoneNumber.getText().toString().trim().equalsIgnoreCase("000000000000000")) {
            Toast.makeText(context, R.string.enter_valid_phone_number, Toast.LENGTH_LONG).show();
            etPhoneNumber.requestFocus();
            return false;
        }
        /*if (!etEmail.getText().toString().trim().matches(EMAIL_PATTERN)) {
            Toast.makeText(context, R.string.please_enter_valid_email, Toast.LENGTH_LONG).show();
            etEmail.requestFocus();
            return true;
        }*/
        return true;
    }

    private void sendOtpApi() {
        CommonUtils.showProgressDialog(context);
        ApiInterface apiServices = ApiClient.getClient(this).create(ApiInterface.class);
        final JsonRequest jsonRequest = new JsonRequest();
        jsonRequest.restaurant_id="";
        jsonRequest.booking_date="";
        jsonRequest.booking_time="";
        jsonRequest.number_of_people="";
        jsonRequest.name="";
        jsonRequest.email=etEmail.getText().toString().trim();
        jsonRequest.contact_no="+"+countryCode+""+etPhoneNumber.getText().toString().trim();

        Call<JsonResponse> call = apiServices.sendOtp(CommonUtils.getPreferences(this,AppConstant.AppToken),jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {
                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {
                    if (response.body().responseCode.equalsIgnoreCase("200")) {
                        showOtpDialog();

                    } else if(response.body().responseCode.equalsIgnoreCase("400"))
                    {
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


    private void otpVerificationApi() {
        CommonUtils.showProgressDialog(context);
        ApiInterface apiServices = ApiClient.getClient(this).create(ApiInterface.class);
        final JsonRequest jsonRequest = new JsonRequest();
        jsonRequest.restaurant_id=restaurantId;
        jsonRequest.booking_date=dateBooked;
        jsonRequest.booking_time=timeBooked;
        jsonRequest.number_of_people=noOfPersons;
        jsonRequest.name=etName.getText().toString().trim();
        jsonRequest.email=etEmail.getText().toString().trim();
        jsonRequest.contact_no="+"+countryCode+""+etPhoneNumber.getText().toString().trim();
        jsonRequest.otp=etEnterOtp.getText().toString().trim();
        Call<JsonResponse> call = apiServices.otpVerification(CommonUtils.getPreferences(this,AppConstant.AppToken),jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {
                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {
                    if (response.body().responseCode.equalsIgnoreCase("200")) {

                        Toast.makeText(context, response.body().responseMessage, Toast.LENGTH_SHORT).show();
                        dialogConfirmBooking.dismiss();

                        intent = new Intent(context, RestaurantReturnToHomeActivity.class);
                        intent.putExtra(AppConstant.RESTAURANTID,restaurantId);
                        intent.putExtra(AppConstant.RESTAURANTNAME,restaurantName);
                        intent.putExtra(AppConstant.LOCATION,location);
                        intent.putExtra(AppConstant.DATEBOOKED,dateBooked);
                        intent.putExtra(AppConstant.TIMEBOOKED,timeBooked);
                        intent.putExtra(AppConstant.NOOFPEOPLE,noOfPersons);
                        intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                        startActivity(intent);


                    } else if(response.body().responseCode.equalsIgnoreCase("400"))
                    {
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


    private void resendOtpService() {
        CommonUtils.showProgressDialog(context);
        ApiInterface apiServices = ApiClient.getClient(this).create(ApiInterface.class);
        final JsonRequest jsonRequest = new JsonRequest();
        jsonRequest.contact_no="+"+countryCode+""+etPhoneNumber.getText().toString().trim();

        Log.e(TAG, "" + new Gson().toJsonTree(jsonRequest).toString().trim());
        Call<JsonResponse> call = apiServices.resendOtp(CommonUtils.getPreferences(this,AppConstant.AppToken),jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {
                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {
                    Log.e(TAG, "" + new Gson().toJsonTree(response.body().toString().trim()));
                    if (response.body().responseCode.equalsIgnoreCase("200")) {

                        Toast.makeText(context, response.body().responseMessage, Toast.LENGTH_SHORT).show();

                    } else if(response.body().responseCode.equalsIgnoreCase("400"))
                    {
                        Toast.makeText(context, response.body().responseMessage, Toast.LENGTH_SHORT).show();
                        sendOtpApi();


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


    /*@Override
    public void onItemSelected(AdapterView<?> adapterView, View view, int i, long l) {
         countryCode=spCountryCode.getSelectedItem().toString().trim();
        //isCountryCodeSelected = true;

    }

    @Override
    public void onNothingSelected(AdapterView<?> adapterView) {
        //  isCountryCodeSelected = true;
    }*/
}
