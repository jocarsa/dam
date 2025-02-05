package com.jocarsa.enviarrecibir

import android.os.Bundle
import androidx.activity.enableEdgeToEdge
import androidx.appcompat.app.AppCompatActivity
import androidx.core.view.ViewCompat
import androidx.core.view.WindowInsetsCompat
import java.io.OutputStreamWriter
import java.net.HttpURLConnection
import java.net.URL

class MainActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.activity_main)
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main)) { v, insets ->
            val systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars())
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom)
            insets
        }

        Thread {
            val url = URL("https://jocarsa.com/go/android/")
            val datos = "nombre=Jose Vicente desde Android"

            val conexion = url.openConnection() as HttpURLConnection
            try {
                conexion.requestMethod = "POST"
                conexion.setRequestProperty("Content-Type", "application/x-www-form-urlencoded; utf-8")
                conexion.setRequestProperty("Accept", "application/json")
                conexion.doOutput = true

                conexion.outputStream.use { outputStream ->
                    OutputStreamWriter(outputStream).use { writer ->
                        writer.write(datos)
                        writer.flush()
                    }
                }

                val responseCode = conexion.responseCode
                println("Response Code: $responseCode")

                conexion.inputStream.bufferedReader().use { reader ->
                    val response = reader.readText()
                    println("Response: $response")
                }
            } catch (e: Exception) {
                e.printStackTrace()
            } finally {
                conexion.disconnect()
            }
        }.start()
    }
}
