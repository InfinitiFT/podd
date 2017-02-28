package com.podd.activityTaxi;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.text.TextUtils;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.google.gson.Gson;
import com.podd.R;
import com.podd.hailoTaxi.HailoDrivers;
import com.podd.hailoTaxi.HailoETA;
import com.podd.hailoTaxi.HailoResponse;
import com.podd.hailoTaxi.ListViewModel;
import com.podd.hailoTaxi.TaxiServiceAsync;
import com.podd.hailoTaxi.TaxiWebServiceStatus;
import com.podd.utils.AppConstant;
import com.podd.utils.CommonUtils;

import java.util.ArrayList;
import java.util.List;


/**
 * The type Main home screen three activity.
 */
public class MainHomeScreenThreeActivity extends AppCompatActivity implements View.OnClickListener {
    private TextView tvBookTaxi;
    private Context context;
    private List<ListViewModel> list = new ArrayList<>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main_home_screen_three);
        context=MainHomeScreenThreeActivity.this;
        getIds();
        setListeners();
    }

    private void getIds() {
        tvBookTaxi= (TextView) findViewById(R.id.tvBookTaxi);
        TextView tvGoingSomewhere = (TextView) findViewById(R.id.tvGoingSomewhere);
        ImageView ivTaxi = (ImageView) findViewById(R.id.ivTaxi);

    }

    private void setListeners() {
        tvBookTaxi.setOnClickListener(this);
    }
    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.tvBookTaxi:
                Intent intent=new Intent(context,BookTaxiActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent);
                callHailoETAApi();
                callHailoDriver();
                break;
        }
    }

    /**
     * This method calls the Hailo App API to find the near by drivers.
     */
    private void callHailoETAApi() {

        /*s*/
        String currentLat="51.507861";
        String currentLng="0.127356";
        CommonUtils.showProgressDialog(context);
        String TOKEN = "E8bEVhHFo7WTrpIgQ9jpSSTaFqzEuqRKVSIh3di7zGKQ5rhZj2UK4ndxwZ4mEKEQgvDF8b/c/rCzwBh4TR6iqUwOhenf5WQSORivTXU6ECtGSSNmMMFK6jmskN8D3QGlRYevARFK+ZJ+luvx7Xz87NO/IGJ45Fte4btUBavPZAfr3CX9UNf5jlr9/DclvjtIykE9UCn3hqsXga/I6FIsAw==";
        String url = "https://api.hailoapp.com/drivers/eta?latitude=" + currentLat + "&longitude=" + currentLng;

        TaxiServiceAsync taxiServiceAsync = new TaxiServiceAsync(context, "", url, "GET", false, TOKEN, "Authorization",
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
                                                                     //   listViewModel.taxiLogo = R.mipmap.hailo;

                                }
                            } catch (NumberFormatException e) {
                                e.printStackTrace();
                            }
                        }
                    } else if (serviceResponse.error != null && !TextUtils.isEmpty(serviceResponse.error.description)) {
                        CommonUtils.showToast(context, serviceResponse.error.description);
                    }
                } else {

                }
            }

            @Override
            public void onFailed(int code) {

                if (code == 400) {
                    CommonUtils.showToast(context, "Hailo not available at this location.");
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
        CommonUtils.showProgressDialog(context);
        String TOKEN = "E8bEVhHFo7WTrpIgQ9jpSSTaFqzEuqRKVSIh3di7zGKQ5rhZj2UK4ndxwZ4mEKEQgvDF8b/c/rCzwBh4TR6iqUwOhenf5WQSORivTXU6ECtGSSNmMMFK6jmskN8D3QGlRYevARFK+ZJ+luvx7Xz87NO/IGJ45Fte4btUBavPZAfr3CX9UNf5jlr9/DclvjtIykE9UCn3hqsXga/I6FIsAw==";
        String url = "https://api.hailoapp.com/drivers/near?latitude=" + currentLat + "&longitude=" + currentLng;

        TaxiServiceAsync taxiServiceAsync = new TaxiServiceAsync(context, "", url, "GET", false, TOKEN, "Authorization",
                "token", new TaxiWebServiceStatus() {
            @Override
            public void onSuccess(Object o) {
                HailoResponse serviceResponse = new Gson().fromJson(o.toString(), HailoResponse.class);
                if (serviceResponse != null) {

                    if (serviceResponse.drivers != null && serviceResponse.drivers.size() > 0) {
                        for (HailoDrivers hailoDrivers : serviceResponse.drivers) {

                        }
                    } else if (serviceResponse.error != null && !TextUtils.isEmpty(serviceResponse.error.description)) {
                        CommonUtils.showToast(context, serviceResponse.error.description);
                    }
                } else {

                }
            }

            @Override
            public void onFailed(int code) {

                if (code == 400) {
                    CommonUtils.showToast(context, "Hailo not available at this location.");
                } else {
                }

            }
        });
        taxiServiceAsync.execute("");
    }

}
