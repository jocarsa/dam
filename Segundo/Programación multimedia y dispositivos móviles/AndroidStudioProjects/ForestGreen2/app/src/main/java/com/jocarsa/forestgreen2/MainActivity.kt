package com.jocarsa.forestgreen2

import android.os.Bundle
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import com.jocarsa.forestgreen2.databinding.ActivityMainBinding
import com.jocarsa.forestgreen2.models.LoginResponse
import com.jocarsa.forestgreen2.network.ApiService
import com.jocarsa.forestgreen2.network.RetrofitClient
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class LoginActivity : AppCompatActivity() {

    private lateinit var binding: ActivityMainBinding
    private val apiService by lazy {
        RetrofitClient.instance.create(ApiService::class.java)
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityMainBinding.inflate(layoutInflater)
        setContentView(binding.root)

        // Handle login button click
        binding.btnLogin.setOnClickListener {
            val username = binding.etUsername.text.toString().trim()
            val password = binding.etPassword.text.toString().trim()

            if (username.isEmpty() || password.isEmpty()) {
                Toast.makeText(this, "Por favor, llena los campos", Toast.LENGTH_SHORT).show()
            } else {
                loginUser(username, password)
            }
        }
    }

    private fun loginUser(username: String, password: String) {
        // 'action' should match your server.php logic, e.g. 'login'
        apiService.login("login", username, password)
            .enqueue(object : Callback<LoginResponse> {
                override fun onResponse(call: Call<LoginResponse>, response: Response<LoginResponse>) {
                    if (response.isSuccessful) {
                        val loginRes = response.body()
                        if (loginRes != null) {
                            if (loginRes.success) {
                                // Login success
                                Toast.makeText(this@LoginActivity, "Bienvenido, $username", Toast.LENGTH_LONG).show()
                                // TODO: Save user_id in preferences and navigate to next screen if needed
                                // e.g. startActivity(Intent(this@LoginActivity, ContactsActivity::class.java))
                                // finish()
                            } else {
                                // Server returned success=false
                                Toast.makeText(this@LoginActivity, loginRes.message, Toast.LENGTH_LONG).show()
                            }
                        } else {
                            Toast.makeText(this@LoginActivity, "Respuesta nula del servidor", Toast.LENGTH_LONG).show()
                        }
                    } else {
                        Toast.makeText(this@LoginActivity, "Error de conexión: ${response.code()}", Toast.LENGTH_LONG).show()
                    }
                }

                override fun onFailure(call: Call<LoginResponse>, t: Throwable) {
                    Toast.makeText(this@LoginActivity, "Fallo al conectar: ${t.message}", Toast.LENGTH_LONG).show()
                }
            })
    }
}