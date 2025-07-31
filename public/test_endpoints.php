<?php
session_start();
require_once __DIR__ . '/../config/config.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔗 API Endpoints Tester</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; }
        .endpoint-group { background: white; margin: 20px 0; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .endpoint { background: #f8f9fa; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #007bff; }
        .method-get { border-left-color: #28a745; }
        .method-post { border-left-color: #dc3545; }
        .endpoint-url { font-family: monospace; background: #e9ecef; padding: 5px 10px; border-radius: 3px; }
        .test-btn { padding: 8px 16px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; margin: 5px; }
        .test-btn:hover { background: #0056b3; }
        .result { margin-top: 10px; padding: 10px; border-radius: 4px; }
        .result.success { background: #d4edda; color: #155724; }
        .result.error { background: #f8d7da; color: #721c24; }
        .server-info { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 8px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="server-info">
            <h1>🔗 Backend API Endpoints Tester</h1>
            <p><strong>Backend URL:</strong> http:
            <p><strong>Port:</strong> 80 (Apache XAMPP)</p>
            <p><strong>Status:</strong> <?php echo $conn ? '✅ Connected' : '❌ Disconnected'; ?></p>
        </div>
        <div class="endpoint-group">
            <h2>🔐 Authentication Endpoints</h2>
            <div class="endpoint method-post">
                <h4>Login</h4>
                <div class="endpoint-url">POST /btl-web/login</div>
                <p>Body: email=admin@example.com&password=password</p>
                <button class="test-btn" onclick="testLogin()">🔓 Test Login</button>
                <div id="login-result" class="result" style="display: none;"></div>
            </div>
            <div class="endpoint method-get">
                <h4>Dashboard (Auth Check)</h4>
                <div class="endpoint-url">GET /btl-web/dashboard</div>
                <button class="test-btn" onclick="testEndpoint('/dashboard', 'dashboard-result')">📊 Test Dashboard</button>
                <div id="dashboard-result" class="result" style="display: none;"></div>
            </div>
            <div class="endpoint method-get">
                <h4>Logout</h4>
                <div class="endpoint-url">GET /btl-web/logout</div>
                <button class="test-btn" onclick="testEndpoint('/logout', 'logout-result')">🚪 Test Logout</button>
                <div id="logout-result" class="result" style="display: none;"></div>
            </div>
        </div>
        <div class="endpoint-group">
            <h2>👨‍💼 Admin Endpoints</h2>
            <div class="endpoint method-get">
                <h4>Manage Majors</h4>
                <div class="endpoint-url">GET /btl-web/majors</div>
                <button class="test-btn" onclick="testEndpoint('/majors', 'majors-result')">📚 Test Majors</button>
                <div id="majors-result" class="result" style="display: none;"></div>
            </div>
            <div class="endpoint method-get">
                <h4>Create Major Form</h4>
                <div class="endpoint-url">GET /btl-web/majors/create</div>
                <button class="test-btn" onclick="testEndpoint('/majors/create', 'majors-create-result')">➕ Test Create Form</button>
                <div id="majors-create-result" class="result" style="display: none;"></div>
            </div>
            <div class="endpoint method-get">
                <h4>Admin Applications</h4>
                <div class="endpoint-url">GET /btl-web/admin/applications</div>
                <button class="test-btn" onclick="testEndpoint('/admin/applications', 'admin-apps-result')">📄 Test Admin Apps</button>
                <div id="admin-apps-result" class="result" style="display: none;"></div>
            </div>
        </div>
        <div class="endpoint-group">
            <h2>👨‍🎓 Student Endpoints</h2>
            <div class="endpoint method-get">
                <h4>Create Application</h4>
                <div class="endpoint-url">GET /btl-web/applications/create</div>
                <button class="test-btn" onclick="testEndpoint('/applications/create', 'app-create-result')">📝 Test App Create</button>
                <div id="app-create-result" class="result" style="display: none;"></div>
            </div>
            <div class="endpoint method-get">
                <h4>My Application</h4>
                <div class="endpoint-url">GET /btl-web/my-application</div>
                <button class="test-btn" onclick="testEndpoint('/my-application', 'my-app-result')">👁️ Test My App</button>
                <div id="my-app-result" class="result" style="display: none;"></div>
            </div>
            <div class="endpoint method-get">
                <h4>Majors Info</h4>
                <div class="endpoint-url">GET /btl-web/majors-info</div>
                <button class="test-btn" onclick="testEndpoint('/majors-info', 'majors-info-result')">📖 Test Majors Info</button>
                <div id="majors-info-result" class="result" style="display: none;"></div>
            </div>
            <div class="endpoint method-get">
                <h4>Admission Results</h4>
                <div class="endpoint-url">GET /btl-web/admission-results</div>
                <button class="test-btn" onclick="testEndpoint('/admission-results', 'admission-result')">🎯 Test Results</button>
                <div id="admission-result" class="result" style="display: none;"></div>
            </div>
            <div class="endpoint method-get">
                <h4>Profile</h4>
                <div class="endpoint-url">GET /btl-web/profile</div>
                <button class="test-btn" onclick="testEndpoint('/profile', 'profile-result')">👤 Test Profile</button>
                <div id="profile-result" class="result" style="display: none;"></div>
            </div>
        </div>
        <div class="endpoint-group">
            <h2>🚀 Quick Actions</h2>
            <div style="text-align: center;">
                <button class="test-btn" onclick="testAllEndpoints()">🧪 Test All Endpoints</button>
                <button class="test-btn" onclick="clearResults()">🧹 Clear Results</button>
                <button class="test-btn" onclick="location.href='backend_test.php'">🔧 Backend Test</button>
                <button class="test-btn" onclick="location.href='final_test.php'">🎉 Final Test</button>
            </div>
        </div>
        <div class="endpoint-group">
            <h2>📋 Sample JavaScript Code</h2>
            <pre style="background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto;">
<code>
async function callAPI(endpoint) {
    try {
        const response = await fetch(`http:
            credentials: 'same-origin'
        });
        if (response.redirected) {
            console.log('Redirected to:', response.url);
            return { redirected: true, url: response.url };
        }
        const text = await response.text();
        return { status: response.status, data: text };
    } catch (error) {
        console.error('API Error:', error);
        return { error: error.message };
    }
}
const result = await callAPI('/dashboard');
console.log(result);</code>
            </pre>
        </div>
    </div>
    <script>
        const BASE_URL = '/btl-web';
        async function testEndpoint(endpoint, resultId) {
            const resultDiv = document.getElementById(resultId);
            resultDiv.style.display = 'block';
            resultDiv.innerHTML = '⏳ Testing...';
            resultDiv.className = 'result';
            try {
                const response = await fetch(BASE_URL + endpoint, {
                    credentials: 'same-origin'
                });
                const statusText = response.status + ' ' + response.statusText;
                if (response.redirected) {
                    resultDiv.innerHTML = `🔄 Redirected (${statusText})<br>URL: ${response.url}`;
                    resultDiv.className = 'result success';
                } else if (response.ok) {
                    const text = await response.text();
                    const preview = text.substring(0, 200) + (text.length > 200 ? '...' : '');
                    resultDiv.innerHTML = `✅ Success (${statusText})<br>Preview: <code>${preview}</code>`;
                    resultDiv.className = 'result success';
                } else {
                    resultDiv.innerHTML = `❌ Error (${statusText})`;
                    resultDiv.className = 'result error';
                }
            } catch (error) {
                resultDiv.innerHTML = `❌ Network Error: ${error.message}`;
                resultDiv.className = 'result error';
            }
        }
        async function testLogin() {
            const resultDiv = document.getElementById('login-result');
            resultDiv.style.display = 'block';
            resultDiv.innerHTML = '⏳ Testing login...';
            resultDiv.className = 'result';
            try {
                const formData = new FormData();
                formData.append('email', 'admin@example.com');
                formData.append('password', 'password');
                const response = await fetch(BASE_URL + '/login', {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin'
                });
                if (response.redirected && response.url.includes('dashboard')) {
                    resultDiv.innerHTML = `✅ Login Success! Redirected to: ${response.url}`;
                    resultDiv.className = 'result success';
                } else if (response.redirected && response.url.includes('login')) {
                    resultDiv.innerHTML = `❌ Login Failed - redirected back to login`;
                    resultDiv.className = 'result error';
                } else {
                    resultDiv.innerHTML = `✅ Login Response: ${response.status} ${response.statusText}`;
                    resultDiv.className = 'result success';
                }
            } catch (error) {
                resultDiv.innerHTML = `❌ Login Error: ${error.message}`;
                resultDiv.className = 'result error';
            }
        }
        async function testAllEndpoints() {
            const endpoints = [
                ['/dashboard', 'dashboard-result'],
                ['/majors', 'majors-result'],
                ['/majors/create', 'majors-create-result'],
                ['/admin/applications', 'admin-apps-result'],
                ['/applications/create', 'app-create-result'],
                ['/majors-info', 'majors-info-result'],
                ['/profile', 'profile-result']
            ];
            for (const [endpoint, resultId] of endpoints) {
                await testEndpoint(endpoint, resultId);
                await new Promise(resolve => setTimeout(resolve, 500));
            }
        }
        function clearResults() {
            const results = document.querySelectorAll('.result');
            results.forEach(result => {
                result.style.display = 'none';
                result.innerHTML = '';
            });
        }
    </script>
</body>
</html> 