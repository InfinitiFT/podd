package com.podd.activityRestaurant;


import android.app.Dialog;
import android.content.Context;
import android.content.Intent;
import android.graphics.Typeface;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.Editable;
import android.text.Html;
import android.text.TextWatcher;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.view.WindowManager;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.google.gson.Gson;
import com.podd.R;
import com.podd.adapter.OrderSummaryAdapter;
import com.podd.model.SavedItem;
import com.podd.retrofit.ApiClient;
import com.podd.retrofit.ApiInterface;
import com.podd.utils.AppConstant;
import com.podd.utils.CommonUtils;
import com.podd.utils.DialogUtils;
import com.podd.utils.SetTimerClass;
import com.podd.webservices.JsonRequest;
import com.podd.webservices.JsonResponse;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;


public class DeliveryBookingSummaryActivity extends AppCompatActivity implements View.OnClickListener, AdapterView.OnItemSelectedListener {
    private Intent intent;
    private Context context;
    private EditText etName;
    private Spinner spCountryCode;
    private EditText etPhoneNumber;
    private EditText etEmail,etAddress;
    private TextView tvCompleteBooking,tvTotalPrice;
    private TextView tvRestaurantName;
    private TextView tvLocation,tvLocationLeft;
    private TextView tvDateBooked,tvDateBookedLeft;
    private TextView tvTimeBooked,tvTimeBookedLeft;
    private TextView tvNumberofPeople,tvNoOfPeopleLeft,tvBookTaxi,tvConfirmation;
    private Dialog dialogConfirmBooking;
    private EditText etEnterOtp1,etEnterOtp2,etEnterOtp3,etEnterOtp4;
    private String location;
    private String dateBooked;
    private String timeBooked;
    private String noOfPersons;
    private String restaurantName;
    private String restaurantId;
    private final String TAG=DeliveryBookingSummaryActivity.class.getSimpleName();
    private String email;
    private String phone;
    private String otp;
  //  private List<String> countryCodeList;
    private final String[]countryCodeArray={"+44","+1","+353","+33","+49","+39","+34","+351","+31","+30","+41","+380","+48","+43","+46","+47","+356","+420","+32","+358","+385","+357","+40","+36","+359","+45","+352","+386","+381","+421","+372","+355","+7","+90","+61","+64","+81","+86","+852","+91","+92","+62","+972","+66","+84","+82","+65","+63","+98","+966","+60","+974","+971","+961","+962","+965","+673","+52","+55","+54","+51","+58","+56","+591","+593","+598","+595","+1876","+1809","+1829","+1849","+27","+234","+20","+218","+212","+213","+216","+233","+244","+251","+254"};
    private String countryCode;
    private SetTimerClass setTimerClass;
    private LinearLayout llNumberPeople;
    private RecyclerView rvOrderList;
    private OrderSummaryAdapter orderSummaryAdapter;
    List<SavedItem> savedItemList;
    private CheckBox cbTermsConditions;
    private TextView tvTermsCondition,tvPrivacyPolicy;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_delivery_summary);
        context = DeliveryBookingSummaryActivity.this;

        getIds();
        setListeners();
        setFont();
        setSpinner();
        savedItemList = new ArrayList<>();
        setTimerClass = (SetTimerClass)getApplication();
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
            tvTotalPrice.setText("TOTAL PRICE: "+getIntent().getStringExtra(AppConstant.TOTAL_PRICE));
        }
        savedItemList = SetTimerClass.savedList;
        orderSummaryAdapter = new OrderSummaryAdapter(this, savedItemList);
        rvOrderList.setAdapter(orderSummaryAdapter);
        rvOrderList.setLayoutManager(new LinearLayoutManager(this));


        /*if(CommonUtils.isNetworkConnected(this)){
            callCountryCode();
        }else {
            CommonUtils.showAlertOk(getString(R.string.Please_connect_to_internet_first),BookingSummaryActivity.this);
        }*/

      /*  spCountryCode.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {

                countryCode="";
                countryCode = countryCodeList.get(position);
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });*/

    }

   /* private void callCountryCode() {
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

    }*/

    private void setSpinner() {
        ArrayAdapter<String> adapter=new ArrayAdapter<>(context,R.layout.row_textview_spinner_type,countryCodeArray);
        adapter.setDropDownViewResource(R.layout.row_report_type_dropdown);
        spCountryCode.setAdapter(adapter);

    }

    private void getIds() {
        tvCompleteBooking = (TextView) findViewById(R.id.tvCompleteBooking);
        tvBookTaxi = (TextView) findViewById(R.id.tvBookTaxi);
        etName = (EditText) findViewById(R.id.etName);
        etAddress = (EditText) findViewById(R.id.etAddress);
        etAddress .setVisibility(View.VISIBLE);
        etAddress.setText(CommonUtils.getPreferences(this,AppConstant.Address));
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
        tvTotalPrice = (TextView) findViewById(R.id.tvTotalPrice);
        llNumberPeople = (LinearLayout) findViewById(R.id.llNumberPeople);
        llNumberPeople.setVisibility(View.GONE);
        rvOrderList = (RecyclerView) findViewById(R.id.rvOrderList);
        tvTermsCondition = (TextView) findViewById(R.id.tvTermsCondition);
        cbTermsConditions = (CheckBox) findViewById(R.id.cbTermsConditions);
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
        tvTotalPrice.setTypeface(typefaceBold);
        etName.setTypeface(typefaceRegular);
        etPhoneNumber.setTypeface(typefaceRegular);
        etEmail.setTypeface(typefaceRegular);

    }

    private void setListeners() {
        tvCompleteBooking.setOnClickListener(this);
        tvTermsCondition.setOnClickListener(this);
        spCountryCode.setOnItemSelectedListener(this);
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()) {
            case R.id.tvCompleteBooking:
                CommonUtils.hideKeyboard(DeliveryBookingSummaryActivity.this);
                if (isValid()) {
                    sendOtpApi();
                    /*name=etName.getText().toString().trim();
                    phone=etPhoneNumber.getText().toString().trim();
                    email=etEmail.getText().toString().trim();*/
                    break;
                }
                break;
            case R.id.tvTermsCondition:
                getPrivacyPolicy();
                // showTermsDialog();
                break;

        }
    }

    private void getPrivacyPolicy() {
        CommonUtils.showProgressDialog(context);
        ApiInterface apiServices = ApiClient.getClient(this).create(ApiInterface.class);
        final JsonRequest jsonRequest = new JsonRequest();
        jsonRequest.page_id="1";
        Call<JsonResponse> call = apiServices.getPrivacyPolicy(CommonUtils.getPreferences(this,AppConstant.AppToken),jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {
                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {
                    if (response.body().responseCode.equalsIgnoreCase("200")) {
                        showTermsDialog(response.body().page_data);
                        // tvPrivacyPolicy.setText(Html.fromHtml(response.body().page_data));
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

    private void showTermsDialog(String policy) {

        LayoutInflater inflater = LayoutInflater.from(this);
        final Dialog mDialog = new Dialog(this,
                android.R.style.Theme_Translucent_NoTitleBar);
        mDialog.setCanceledOnTouchOutside(true);
        mDialog.getWindow().setLayout(ViewGroup.LayoutParams.MATCH_PARENT,
                ViewGroup.LayoutParams.MATCH_PARENT);
        mDialog.getWindow().setGravity(Gravity.CENTER);
        WindowManager.LayoutParams lp = mDialog.getWindow().getAttributes();
        lp.dimAmount = 0.75f;
        mDialog.getWindow()
                .addFlags(WindowManager.LayoutParams.FLAG_DIM_BEHIND);
        mDialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
        mDialog.getWindow();
        final ViewGroup nullParent = null;
        View dialogLayout = inflater.inflate(R.layout.dialog_terms_condition, nullParent);
        mDialog.setContentView(dialogLayout);
        ImageView ivCross=(ImageView)mDialog.findViewById(R.id.ivPicsCross);
        tvPrivacyPolicy = (TextView) mDialog.findViewById(R.id.tvPrivacyPolicy);
        Typeface typefaceRegular = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Regular.ttf");
        tvPrivacyPolicy.setTypeface(typefaceRegular);
        tvPrivacyPolicy.setText(Html.fromHtml(policy));
        //  getPrivacyPolicy();

        ivCross.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                mDialog.dismiss();
            }
        });
        mDialog.show();
    }

    private void showOtpDialog() {
        dialogConfirmBooking = DialogUtils.createCustomDialog(context, R.layout.dialog_booking_confirmation);
        TextView tvSubmit = (TextView) dialogConfirmBooking.findViewById(R.id.tvSubmit);
        TextView tvEnterYourEmailId = (TextView) dialogConfirmBooking.findViewById(R.id.tvEnterYourEmailId);
        TextView tvResendOtp = (TextView) dialogConfirmBooking.findViewById(R.id.tvResendOtp);
        etEnterOtp1 = (EditText) dialogConfirmBooking.findViewById(R.id.etEnterOtp1);
        etEnterOtp2 = (EditText) dialogConfirmBooking.findViewById(R.id.etEnterOtp2);
        etEnterOtp3 = (EditText) dialogConfirmBooking.findViewById(R.id.etEnterOtp3);
        etEnterOtp4 = (EditText) dialogConfirmBooking.findViewById(R.id.etEnterOtp4);
        Typeface typefaceBold = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Bold.ttf");
        tvEnterYourEmailId.setTypeface(typefaceBold);
        tvSubmit.setTypeface(typefaceBold);
        tvResendOtp.setTypeface(typefaceBold);
        Typeface typefaceRegular = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Regular.ttf");
        etEnterOtp1.setTypeface(typefaceRegular);
        etEnterOtp2.setTypeface(typefaceRegular);
        etEnterOtp3.setTypeface(typefaceRegular);
        etEnterOtp4.setTypeface(typefaceRegular);

        etEnterOtp1.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {
                if(etEnterOtp1.getText().toString().trim().length()==1){
                    etEnterOtp2.requestFocus();
                }
            }

            @Override
            public void afterTextChanged(Editable editable) {

            }
        });

        etEnterOtp2.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {
                if(etEnterOtp2.getText().toString().trim().length()==1){
                    etEnterOtp3.requestFocus();
                }
            }

            @Override
            public void afterTextChanged(Editable editable) {

            }
        });

        etEnterOtp3.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {
                if(etEnterOtp3.getText().toString().trim().length()==1){
                    etEnterOtp4.requestFocus();
                }
            }

            @Override
            public void afterTextChanged(Editable editable) {

            }
        });

        etEnterOtp4.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {
                if(etEnterOtp4.getText().toString().trim().length()==1){

                }
            }

            @Override
            public void afterTextChanged(Editable editable) {

            }
        });

        tvSubmit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(isValidOtp()) {
                    otp=etEnterOtp1.getText().toString().trim()+etEnterOtp2.getText().toString().trim()+etEnterOtp3.getText().toString().trim()+etEnterOtp4.getText().toString().trim();
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
        if (etEnterOtp1.getText().toString().trim().isEmpty() && etEnterOtp2.getText().toString().trim().isEmpty() && etEnterOtp3.getText().toString().trim().isEmpty() && etEnterOtp4.getText().toString().trim().isEmpty()) {
            Toast.makeText(context, R.string.please_enter_otp, Toast.LENGTH_SHORT).show();
            return false;
        } else if (etEnterOtp1.getText().toString().trim().length()<1 && etEnterOtp2.getText().toString().trim().length()<1 && etEnterOtp3.getText().toString().trim().length()<1 && etEnterOtp4.getText().toString().trim().length()<1) {
            Toast.makeText(context, R.string.please_enter_valid_otp, Toast.LENGTH_SHORT).show();
            return false;
        }
        return true;
    }


    private boolean isValid() {
     //   String EMAIL_PATTERN = "^[_A-Za-z0-9-]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$";
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
        }else if(!cbTermsConditions.isChecked()){
            Toast.makeText(context, R.string.privacy_policy_error_msg, Toast.LENGTH_LONG).show();
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
        jsonRequest.contact_no=countryCode+""+etPhoneNumber.getText().toString().trim();

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
       // jsonRequest.number_of_people=noOfPersons;
        List<SavedItem> orderDetailList = SetTimerClass.savedList;
        jsonRequest.order_details = orderDetailList;
        jsonRequest.total_price = getIntent().getStringExtra(AppConstant.TOTAL_PRICE);
        jsonRequest.name=etName.getText().toString().trim();
        jsonRequest.email=etEmail.getText().toString().trim();
        jsonRequest.address=etAddress.getText().toString().trim();
        jsonRequest.contact_no=countryCode+""+etPhoneNumber.getText().toString().trim();
        jsonRequest.otp=etEnterOtp1.getText().toString().trim()+etEnterOtp2.getText().toString().trim()+etEnterOtp3.getText().toString().trim()+etEnterOtp4.getText().toString().trim();
        Call<JsonResponse> call = apiServices.deliveryBooking(CommonUtils.getPreferences(this,AppConstant.AppToken),jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {
                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {
                    if (response.body().responseCode.equalsIgnoreCase("200")) {

                        Toast.makeText(context, R.string.booking_request, Toast.LENGTH_SHORT).show();
                        dialogConfirmBooking.dismiss();

                        intent = new Intent(context, RestaurantReturnToHomeActivity.class);
                        intent.putExtra(AppConstant.RESTAURANTID,restaurantId);
                        intent.putExtra(AppConstant.RESTAURANTNAME,restaurantName);
                        intent.putExtra(AppConstant.TOTAL_PRICE,getIntent().getStringExtra(AppConstant.TOTAL_PRICE));
                        intent.putExtra(AppConstant.LOCATION,location);
                        intent.putExtra(AppConstant.DATEBOOKED,dateBooked);
                        intent.putExtra(AppConstant.TIMEBOOKED,timeBooked);
                        intent.putExtra(AppConstant.NOOFPEOPLE,noOfPersons);
                        intent.putExtra(AppConstant.Delivery,"1");
                        intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                        startActivity(intent);
                        //SetTimerClass.savedList.clear();
                        CommonUtils.savePreferencesString(DeliveryBookingSummaryActivity.this,AppConstant.Address,"");


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
        jsonRequest.contact_no=countryCode+""+etPhoneNumber.getText().toString().trim();

        Log.e(TAG, "" + new Gson().toJsonTree(jsonRequest).toString().trim());
        Call<JsonResponse> call = apiServices.resendOtp(CommonUtils.getPreferences(this,AppConstant.AppToken),jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {
                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {
                    Log.e(TAG, "" + new Gson().toJsonTree(response.body().toString().trim()));
                    if (response.body().responseCode.equalsIgnoreCase("200")) {
                        etEnterOtp1.setText("");
                        etEnterOtp2.setText("");
                        etEnterOtp3.setText("");
                        etEnterOtp4.setText("");
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


    @Override
    public void onItemSelected(AdapterView<?> adapterView, View view, int i, long l) {
         countryCode=spCountryCode.getSelectedItem().toString().trim();
        //isCountryCodeSelected = true;

    }

    @Override
    public void onNothingSelected(AdapterView<?> adapterView) {
        //  isCountryCodeSelected = true;
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
