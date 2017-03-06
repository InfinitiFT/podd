package com.podd.activityRestaurant;

import android.app.DatePickerDialog;
import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.graphics.Typeface;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.util.TypedValue;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.DatePicker;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.google.gson.Gson;
import com.podd.R;
import com.podd.adapter.RestaurantsAdapter;
import com.podd.retrofit.ApiClient;
import com.podd.retrofit.ApiInterface;
import com.podd.utils.AppConstant;
import com.podd.utils.CommonUtils;
import com.podd.utils.SetTimerClass;
import com.podd.webservices.JsonRequest;
import com.podd.webservices.JsonResponse;

import java.io.Serializable;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Calendar;
import java.util.Date;
import java.util.List;
import java.util.Locale;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

/**
 * The type Restraunt booking details activity.
 */
@SuppressWarnings("ALL")
public class RestaurantBookingDetailsActivity extends AppCompatActivity implements View.OnClickListener,Serializable,SearchableListDialog.SearchableItem ,SearchableLocationListDialog.SearchableItem {
    private Context context;
    private RecyclerView rvRestaurants;
    private TextView tvBookNow;
    private Spinner spSelectTime;
    private Spinner spSelectPeople;
    private TextView tvSelectfromCalender,tvBookingSummary;
    private TextView tvRestauarntName, tvSelectPeople;
    private TextView tvToday,tvDate,tvTime;
    private TextView tvTomorrow;
    private TextView tvDateBooked;
    private TextView tvTimeBooked,tvTimeSpinner;
    private TextView tvNoOfPersons,tvSelect;
    private ArrayList<String> restaurantImages;
    private String restaurantName;
    private final String[] numberOfPeopleArray = {/*"Number of people",*/ "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"};
    private String date;
    private final String TAG = RestaurantBookingDetailsActivity.class.getSimpleName();
    private String restaurantantId;
    private String location;
    private String dateBooked;
    private String timeBooked;

    private String noOfPersons;
    private String condition;
    private List<String>restaurantTimeInterval=new ArrayList<>();
    private ArrayList<String> timeItems = new ArrayList<>();
    ArrayAdapter<String> arrayAdapterTime;
    private SetTimerClass setTimerClass;
    private SearchableListDialog _searchableListDialog;
    private String selectedItem = "";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_restraunt_booking_details);
        context = RestaurantBookingDetailsActivity.this;
        getIds();
        setFont();
        setTimerClass = (SetTimerClass)getApplication();
        if(getIntent()!= null) {
            restaurantImages = (ArrayList<String>) getIntent().getSerializableExtra(AppConstant.RESTAURANTIMAGES);
            restaurantName = getIntent().getStringExtra(AppConstant.RESTAURANTNAME);
            tvRestauarntName.setText(restaurantName);
            restaurantantId = getIntent().getStringExtra(AppConstant.RESTAURANTID);
            location = getIntent().getStringExtra(AppConstant.LOCATION);

        }

        //selectNumberOfPeopleAdapter();
        setAdapter();
        setListeners();


        spSelectTime.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> adapterView, View view, int i, long l) {
                if (restaurantTimeInterval!=null&&restaurantTimeInterval.size()>0) {
                    if(i>0){
                        Calendar  current=Calendar.getInstance();
                        Date date= new Date(  System.currentTimeMillis());
                        System.out.println(date);
                        SimpleDateFormat simpDate,simpDate1;
                        simpDate = new SimpleDateFormat("kk:mm");
                        simpDate1 = new SimpleDateFormat("dd-MMM-yyyy");
                        String currentTime=simpDate.format(date);
                        String currentDate=simpDate1.format(date);
                        // System.out.println("time>>"+simpDate.format(date));
                        //   Date todayDate = new Date(tvDateBooked.getText().toString().trim());
                        if(tvDateBooked.getText().toString().trim().equals(currentDate)){
                            if(Float.parseFloat((spSelectTime.getSelectedItem().toString().replace(":","")).trim())<=Float.parseFloat((currentTime.replace(":","")).trim()))
                            {
                                spSelectTime.setSelection(0);
                                Toast.makeText(RestaurantBookingDetailsActivity.this,getString(R.string.please_select_a_valid_time),Toast.LENGTH_SHORT).show();

                            }else{
                                // spSelectTime.setSelection(i);
                                tvTimeSpinner.setText(spSelectTime.getSelectedItem().toString());
                                tvTimeBooked.setText(spSelectTime.getSelectedItem() != null ? spSelectTime.getSelectedItem().toString() : restaurantTimeInterval.get(0));

                            }
                        }else{
                            // spSelectTime.setSelection(i);
                            tvTimeSpinner.setText(spSelectTime.getSelectedItem().toString());
                            tvTimeBooked.setText(spSelectTime.getSelectedItem() != null ? spSelectTime.getSelectedItem().toString() : restaurantTimeInterval.get(0));

                        }
                    }
                }
            }

            @Override
            public void onNothingSelected(AdapterView<?> adapterView) {

            }
        });
    }

    private void getIds() {
        rvRestaurants = (RecyclerView) findViewById(R.id.rvRestaurants);
        tvBookNow = (TextView) findViewById(R.id.tvBookNow);
        tvTimeSpinner = (TextView) findViewById(R.id.tvTimeSpinner);
        tvSelectfromCalender = (TextView) findViewById(R.id.tvSelectfromCalender);
        tvDate = (TextView) findViewById(R.id.tvDate);
        tvTime = (TextView) findViewById(R.id.tvTime);
        tvSelectPeople = (TextView) findViewById(R.id.tvSelectPeople);
        tvBookingSummary = (TextView) findViewById(R.id.tvBookingSummary);
        spSelectTime = (Spinner) findViewById(R.id.spSelectTime);
        spSelectPeople = (Spinner) findViewById(R.id.spSelectPeople);
        tvRestauarntName = (TextView) findViewById(R.id.tvRestauarntName);
        TextView tvDate = (TextView) findViewById(R.id.tvDate);
        tvToday = (TextView) findViewById(R.id.tvToday);
        tvTomorrow = (TextView) findViewById(R.id.tvTomorrow);
        TextView tvTime = (TextView) findViewById(R.id.tvTime);
        TextView tvBookingSummary = (TextView) findViewById(R.id.tvBookingSummary);
        tvDateBooked = (TextView) findViewById(R.id.tvDateBooked);
        tvTimeBooked = (TextView) findViewById(R.id.tvTimeBooked);
        tvNoOfPersons = (TextView) findViewById(R.id.tvNoOfPersons);
        tvSelect = (TextView) findViewById(R.id.tvSelect);

    }

    private void setFont() {
        Typeface typeface = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Regular.ttf");
        Typeface typefaceBold = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Bold.ttf");
        tvRestauarntName.setTypeface(typefaceBold);
        tvBookNow.setTypeface(typefaceBold);
        tvDate.setTypeface(typeface);
        tvToday.setTypeface(typeface);
        tvTomorrow.setTypeface(typeface);
        tvSelectfromCalender.setTypeface(typeface);
        tvTime.setTypeface(typeface);
        tvBookingSummary.setTypeface(typeface);
        tvDateBooked.setTypeface(typeface);
        tvTimeBooked.setTypeface(typeface);
        tvNoOfPersons.setTypeface(typeface);
    }


    /*private void selectNumberOfPeopleAdapter() {

        ArrayAdapter<String> adapter = new ArrayAdapter<String>(context, R.layout.row_textview_spinner_type, numberOfPeopleArray);
        adapter.setDropDownViewResource(R.layout.row_report_type_dropdown);
        spSelectPeople.setAdapter(adapter);

    }*/

    private void setListeners() {
        tvSelectfromCalender.setOnClickListener(this);
        /*spSelectPeople.setOnItemSelectedListener(this);
        spSelectTime.setOnItemSelectedListener(this);*/
        tvToday.setOnClickListener(this);
        tvTomorrow.setOnClickListener(this);
        tvTimeSpinner.setOnClickListener(this);
        tvBookNow.setOnClickListener(this);
        tvSelect.setOnClickListener(this);

    }

    private void setAdapter() {
        RestaurantsAdapter RestaurantsAdapter = new RestaurantsAdapter(context, restaurantImages);
        RecyclerView.LayoutManager mLayoutManager = new LinearLayoutManager(context, LinearLayoutManager.HORIZONTAL, false);
        rvRestaurants.setLayoutManager(mLayoutManager);
        rvRestaurants.setAdapter(RestaurantsAdapter);
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()) {
            case R.id.tvBookNow:
                /*dateBooked = tvDateBooked.getText().toString().trim();
                timeBooked = tvTimeBooked.getText().toString().trim();
                noOfPersons = tvNoOfPersons.getText().toString().trim();*/
                if (isValid()) {
                    Intent intent = new Intent(context, BookingSummaryActivity.class);
                    intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                    intent.putExtra(AppConstant.DATEBOOKED, tvDateBooked.getText().toString().trim());
                    intent.putExtra(AppConstant.TIMEBOOKED, tvTimeBooked.getText().toString().trim());
                    intent.putExtra(AppConstant.NOOFPEOPLE, tvNoOfPersons.getText().toString().trim());
                    intent.putExtra(AppConstant.LOCATION, location);
                    intent.putExtra(AppConstant.RESTAURANTNAME, restaurantName);
                    intent.putExtra(AppConstant.RESTAURANTID, restaurantantId);
                    startActivity(intent);
                }
                break;
            case R.id.tvSelectfromCalender:
                tvToday.setText(R.string.today);
                tvTomorrow.setText(R.string.tomorrow);
                pickDate();
                break;
            case R.id.tvTimeSpinner:
                if(restaurantTimeInterval.size()>0){
                    spSelectTime.performClick();
                }else{
                    Toast.makeText(this,"Please select date",Toast.LENGTH_LONG).show();
                }

                break;
            case R.id.tvTomorrow:
                tvToday.setText(R.string.today);
                tvSelectfromCalender.setText(R.string.select_from_calender);

                 /*  getting tomorrow date  */

                date = new SimpleDateFormat("dd-MMM-yyyy").format(System.currentTimeMillis() + (24 * 3600000));
              /*  date = DateFormat.getDateInstance().format(System.currentTimeMillis() + (24 * 3600000));*/
                tvTomorrow.setText(date);
                tvDateBooked.setText(date);
                getRestauranttimeIntervalApi(date);
                arrayAdapterTime = new ArrayAdapter<String>(RestaurantBookingDetailsActivity.this, R.layout.row_textview_spinner_type, timeItems) {
                    @Override
                    public boolean isEnabled(int position) {
                        return position != 0;
                    }

                    @Override
                    public View getDropDownView(int position, View convertView,
                                                ViewGroup parent) {
                        View view = super.getDropDownView(position, convertView, parent);
                        TextView tv = (TextView) view;
                        tv.setTextSize(TypedValue.COMPLEX_UNIT_PX,getResources().getDimension(R.dimen.text_size_6));
//                        if (position == 0) {
//                            // Set the hint text color gray
//                            tv.setTextColor(Color.WHITE);
//                        } else {
                            tv.setTextColor(Color.BLACK);
//                        }
                        return view;
                    }
                };
                spSelectTime.setAdapter(arrayAdapterTime);
                // }
                break;

            case R.id.tvToday:
                tvSelectfromCalender.setText(R.string.select_from_calender);
                tvTomorrow.setText(R.string.tomorrow);

                /*  getting current date  */
                date = new SimpleDateFormat("dd-MMM-yyyy").format(new Date());
                tvToday.setText(date);
                tvDateBooked.setText(date);
                getRestauranttimeIntervalApi(date);
                arrayAdapterTime = new ArrayAdapter<String>(RestaurantBookingDetailsActivity.this, R.layout.row_textview_spinner_type, timeItems) {
                    @Override
                    public boolean isEnabled(int position) {
                        return position != 0;
                    }

                    @Override
                    public View getDropDownView(int position, View convertView,
                                                ViewGroup parent) {
                        View view = super.getDropDownView(position, convertView, parent);
                        TextView tv = (TextView) view;
                        tv.setTextSize(TypedValue.COMPLEX_UNIT_PX,getResources().getDimension(R.dimen.text_size_6));
//                        if (position == 0) {
//                             Set the hint text color gray
//                            tv.setTextColor(Color.WHITE);
//                        } else {
                            tv.setTextColor(Color.BLACK);

//                        }
                        return view;
                    }
                };
                spSelectTime.setAdapter(arrayAdapterTime);
                break;

            case R.id.tvSelect:
               // cuisineList.addAll(response.body().allList);
                _searchableListDialog = SearchableListDialog.newInstance(Arrays.asList(numberOfPeopleArray));
                selectedItem = "number_of_people";
                _searchableListDialog.setOnSearchableItemClickListener(RestaurantBookingDetailsActivity.this);
                _searchableListDialog.show(getFragmentManager(), TAG);
                _searchableListDialog.setTitle(getString(R.string.select));
                break;

        }
    }


    private void pickDate() {
        final Calendar calendar = Calendar.getInstance();
        int cYear = calendar.get(Calendar.YEAR);
        final int cMonth = calendar.get(Calendar.MONTH);
        final int cDay = calendar.get(Calendar.DAY_OF_MONTH);

        DatePickerDialog dpd = new DatePickerDialog(context, new DatePickerDialog.OnDateSetListener() {

            @Override
            public void onDateSet(DatePicker view, int year, int monthOfYear, int dayOfMonth) {
                calendar.set(year, monthOfYear, dayOfMonth);
                SimpleDateFormat simpleDateFormat = new SimpleDateFormat("dd-MM-yyyy", Locale.getDefault());
                date = simpleDateFormat.format(calendar.getTime());
                //selected = Long.parseLong(String.valueOf((CommonUtils.getTimeStampDate(date, "dd/MM/yyyy"))));

                tvSelectfromCalender.setText(date);
                tvDateBooked.setText(date);
                getRestauranttimeIntervalApi(  date);

                CommonUtils.savePreferenceInt(context, AppConstant.YEAR, year);
                CommonUtils.savePreferenceInt(context, AppConstant.MONTH, monthOfYear);
                CommonUtils.savePreferenceInt(context, AppConstant.DATE, dayOfMonth);
            }
        }, cYear, cMonth, cDay);
        DatePicker dp = dpd.getDatePicker();
        if (date != null) {
            dpd.getDatePicker().updateDate(CommonUtils.getPreferencesInt(context, AppConstant.YEAR), CommonUtils.getPreferencesInt(context, AppConstant.MONTH), CommonUtils.getPreferencesInt(context, AppConstant.DATE));
        } else {
            dp.setMaxDate(Calendar.getInstance().getTimeInMillis());
        }
        dpd.show();
        dpd.getDatePicker().setMinDate(System.currentTimeMillis()-1000);
        dpd.getDatePicker().setMaxDate(System.nanoTime());
        dpd.setCancelable(true);
    }

    private void getRestauranttimeIntervalApi(String date) {
        CommonUtils.showProgressDialog(context);
        ApiInterface apiServices = ApiClient.getClient(this).create(ApiInterface.class);
        final JsonRequest jsonRequest = new JsonRequest();
        jsonRequest.restaurant_id = restaurantantId;
        jsonRequest.date=date;

        Call<JsonResponse> call = apiServices.getRestaurantTimeInterval(CommonUtils.getPreferences(this,AppConstant.AppToken),jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {
                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {
                    Log.e(TAG, "" + new Gson().toJsonTree(response.body().toString().trim()));
                    if (response.body().responseCode.equalsIgnoreCase("200")) {
                        if (response.body().restaurant_time_interval!=null&&response.body().restaurant_time_interval.size()>0) {
                            restaurantTimeInterval.clear();
                            restaurantTimeInterval.addAll(response.body().restaurant_time_interval);

                            timeItems.add("Select Time");

                            for (int i = 0; i < restaurantTimeInterval.size(); i++) {
                                timeItems.add(restaurantTimeInterval.get(i));
                            }


                            ArrayAdapter<String> arrayAdapterTime = new ArrayAdapter<String>(RestaurantBookingDetailsActivity.this, R.layout.row_textview_spinner_type, timeItems) {
                                @Override
                                public boolean isEnabled(int position) {
                                    return position != 0;
                                }

                                @Override
                                public View getDropDownView(int position, View convertView,
                                                            ViewGroup parent) {
                                    View view = super.getDropDownView(position, convertView, parent);
                                    TextView tv = (TextView) view;
                                    tv.setTextSize(TypedValue.COMPLEX_UNIT_PX,getResources().getDimension(R.dimen.text_size_6));

                                    if (position == 0) {
                                        // Set the hint text color gray
                                        tv.setTextColor(Color.GRAY);

                                    } else {
                                        Calendar  current=Calendar.getInstance();
                                        try
                                        {
                                            Date date= new Date(  System.currentTimeMillis());
                                            System.out.println(date);
                                            SimpleDateFormat simpDate,simpDate1;
                                            simpDate = new SimpleDateFormat("kk:mm");
                                            simpDate1 = new SimpleDateFormat("dd-MMM-yyyy");
                                            String currentTime=simpDate.format(date);
                                            String currentDate=simpDate1.format(date);
                                            if(tvDateBooked.getText().toString().trim().equals(currentDate)){
                                                if(Float.parseFloat((timeItems.get(position).replace(":","")).trim())<=Float.parseFloat((currentTime.replace(":","")).trim()))
                                                {
                                                    tv.setTextColor(Color.GRAY);
                                                }else {
                                                    tv.setTextColor(Color.BLACK);
                                                }
                                            }else{
                                                tv.setTextColor(Color.BLACK);
                                            }

                                        }catch (Exception e)
                                        {
                                            e.printStackTrace();
                                        }
                                    }
                                    return view;
                                }
                            };
                            spSelectTime.setAdapter(arrayAdapterTime);
                        } else {
                            CommonUtils.showAlertOk(getString(R.string.not_available),RestaurantBookingDetailsActivity.this);
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

        switch (selectedItem) {

            case "number_of_people":
                tvSelect.setText(item.toString().trim());
                tvNoOfPersons.setText(tvSelect.getText().toString().trim());
                break;
            case "time":

                break;

        }
    }

    private boolean isValid() {
        if (tvDateBooked.getText().toString().trim().matches(getString(R.string.date))) {
            Toast.makeText(context, R.string.please_select_a_valid_date, Toast.LENGTH_LONG).show();
            return false;
        } else if (tvTimeBooked.getText().toString().trim().matches(getString(R.string.time)) || tvTimeBooked.getText().toString().trim().matches(getString(R.string.select_time))) {
            Toast.makeText(context, R.string.please_select_a_valid_time, Toast.LENGTH_LONG).show();
            return false;
        } else if (tvNoOfPersons.getText().toString().trim().matches(getString(R.string.number_of_persons))) {
            Toast.makeText(context, R.string.please_select_number_of_people, Toast.LENGTH_LONG).show();
            return false;
        }
        return true;
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
