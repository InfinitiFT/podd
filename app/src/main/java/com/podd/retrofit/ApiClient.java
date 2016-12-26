package com.podd.retrofit;


import android.util.Base64;
import java.io.IOException;
import java.util.concurrent.TimeUnit;
import okhttp3.Interceptor;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.Response;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;


/**
 * The type Api client.
 */
public class ApiClient {

    /**
     * The constant BASE_URL.
     */
    public static final String BASE_URL = "http:172.16.0.9/PROJECTS/IOSNativeAppDevelopment/trunk/webservices/";
   // public static final String BASE_URL = "http:172.16.0.9/PROJECTS/IOSNativeAppDevelopment/trunk/webservices/";

    private static Retrofit retrofit = null;


    public static ApiInterface getApiService() {
        String credentials = "admin"+":"+"1234";
        final String basic = "Basic " + Base64.encodeToString(credentials.getBytes(), Base64.NO_WRAP);
        OkHttpClient okHttpClient = new OkHttpClient();
        Retrofit retrofit = new Retrofit.Builder()
                .baseUrl(BASE_URL)
                .addConverterFactory(GsonConverterFactory.create())
                .client(okHttpClient.newBuilder().connectTimeout(2 * 60 * 1000, TimeUnit.SECONDS).readTimeout(2 * 60 * 1000, TimeUnit.SECONDS).writeTimeout(2 * 60 * 1000, TimeUnit.SECONDS)
                        .addInterceptor(new Interceptor() {
                            @Override
                            public Response intercept(Chain chain) throws IOException {
                                Request original = chain.request();
                                Request.Builder requestBuilder = original.newBuilder()
                                        .header("Authorization", basic)
                                        .method(original.method(), original.body());

                                Request request = requestBuilder.build();
                                return chain.proceed(request);
                            }
                        }).build()).build();
        return retrofit.create(ApiInterface.class);
    }


}
