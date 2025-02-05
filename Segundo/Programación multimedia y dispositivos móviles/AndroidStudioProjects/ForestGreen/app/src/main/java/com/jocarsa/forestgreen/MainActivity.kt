package com.jocarsa.forestgreen

import android.os.Bundle
import android.webkit.WebSettings
import androidx.activity.enableEdgeToEdge
import androidx.appcompat.app.AppCompatActivity
import androidx.core.view.ViewCompat
import androidx.core.view.WindowInsetsCompat
import android.webkit.WebView                                           // Agrego librería webview
import android.webkit.WebViewClient

class MainActivity : AppCompatActivity() {
    private lateinit var mivistaweb: WebView
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.activity_main)
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main)) { v, insets ->
            val systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars())
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom)
            insets
        }
        mivistaweb = findViewById(R.id.mivistaweb)                      // Selecciono el elemento por su id
        mivistaweb.webViewClient = WebViewClient();                     // Arranco un cliente web

        val parametrosWeb: WebSettings = mivistaweb.settings            // Creo un contenedor de parámetros
        parametrosWeb.javaScriptEnabled = true                        // Mi proyecto usa Javascript
        parametrosWeb.domStorageEnabled = true

        mivistaweb.loadUrl("file:///android_asset/web/index.html")


    }
}