<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SMTP Mail Checker - Örnek Github Projesidir. Açık kaynak kullanılabilir.">
    <meta name="author" content="Alperen İrtik">
    <meta name="keywords" content="SMTP, Mail Checker, PHP, Open Source, GitHub">
    <title>SMTP Mail Checker - Örnek Github Projesidir</title>
    <link rel="icon" type="image/png" href="favicon.ico">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-gradient-to-br from-indigo-100 to-purple-100 min-h-screen flex flex-col">
    <div class="flex-grow py-6 px-4 sm:py-12 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto" x-data="{
            host: '',
            port: '',
            username: '',
            password: '',
            encryption: 'tls',
            fromEmail: '',
            toEmail: '',
            loading: false,
            result: null,
            async checkSMTP() {
                this.loading = true;
                this.result = null;
                
                try {
                    const response = await fetch('check_smtp.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams({
                            host: this.host,
                            port: this.port,
                            username: this.username,
                            password: this.password,
                            encryption: this.encryption,
                            fromEmail: this.fromEmail,
                            toEmail: this.toEmail
                        })
                    });
                    
                    const data = await response.json();
                    this.result = data;
                } catch (error) {
                    this.result = {
                        success: false,
                        message: 'SMTP bağlantısı kontrol edilirken bir hata oluştu'
                    };
                }
                
                this.loading = false;
            }
        }">
            <div class="bg-white shadow-2xl rounded-2xl p-6 sm:p-8 backdrop-blur-sm bg-opacity-90">
                <div class="text-center mb-8">
                    <i class="fas fa-envelope-circle-check text-4xl sm:text-5xl text-indigo-600 mb-4"></i>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">SMTP Mail Checker</h2>
                    <p class="text-gray-600 mt-2 text-sm sm:text-base">Mail sunucusu bağlantınızı test edin</p>
                </div>

                <!-- Nasıl Çalışır Bölümü -->
                <div class="mb-8 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <h3 class="text-lg font-medium text-blue-900 mb-3">
                        <i class="fas fa-circle-info mr-2"></i>
                        Sistem Nasıl Çalışır?
                    </h3>
                    <div class="space-y-2 text-blue-800 text-sm">
                        <p class="flex items-start">
                            <i class="fas fa-check-circle mt-1 mr-2"></i>
                            <span>SMTP sunucu bilgilerinizi (host, port, kullanıcı adı, şifre) ve güvenlik tipini girin.</span>
                        </p>
                        <p class="flex items-start">
                            <i class="fas fa-check-circle mt-1 mr-2"></i>
                            <span>Test için kullanılacak gönderici ve alıcı e-posta adreslerini belirtin.</span>
                        </p>
                        <p class="flex items-start">
                            <i class="fas fa-check-circle mt-1 mr-2"></i>
                            <span>Sistem önce SMTP sunucusuna bağlanır ve kimlik doğrulaması yapar.</span>
                        </p>
                        <p class="flex items-start">
                            <i class="fas fa-check-circle mt-1 mr-2"></i>
                            <span>Bağlantı başarılıysa, test e-postası gönderilir ve tüm işlem adımları loglanır.</span>
                        </p>
                        <p class="flex items-start">
                            <i class="fas fa-check-circle mt-1 mr-2"></i>
                            <span>Sonuçları ve detaylı logları görüntüleyebilir, indirebilir veya kopyalayabilirsiniz.</span>
                        </p>
                    </div>
                </div>
                
                <form @submit.prevent="checkSMTP" class="space-y-8">
                    <!-- SMTP Sunucu Bilgileri -->
                    <div class="border-b border-gray-200 pb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Sunucu Bilgileri</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="relative">
                                <label class="block text-sm sm:text-base font-medium text-gray-700 mb-2">Sunucu Adresi</label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-server text-gray-400"></i>
                                    </div>
                                    <input type="text" x-model="host" placeholder="örn: smtp.gmail.com" 
                                        class="block w-full pl-11 pr-4 py-3 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base" required>
                                </div>
                            </div>
                            
                            <div class="relative">
                                <label class="block text-sm sm:text-base font-medium text-gray-700 mb-2">Port</label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-plug text-gray-400"></i>
                                    </div>
                                    <input type="number" x-model="port" placeholder="örn: 587" 
                                        class="block w-full pl-11 pr-4 py-3 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base" required>
                                </div>
                            </div>
                            
                            <div class="relative">
                                <label class="block text-sm sm:text-base font-medium text-gray-700 mb-2">Kullanıcı Adı</label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input type="text" x-model="username" placeholder="E-posta adresiniz" 
                                        class="block w-full pl-11 pr-4 py-3 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base" required>
                                </div>
                            </div>
                            
                            <div class="relative">
                                <label class="block text-sm sm:text-base font-medium text-gray-700 mb-2">Şifre</label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </div>
                                    <input type="password" x-model="password" placeholder="SMTP şifreniz" 
                                        class="block w-full pl-11 pr-4 py-3 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base" required>
                                </div>
                            </div>
                            
                            <div class="relative md:col-span-2">
                                <label class="block text-sm sm:text-base font-medium text-gray-700 mb-2">Güvenlik</label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-shield-halved text-gray-400"></i>
                                    </div>
                                    <select x-model="encryption" 
                                        class="block w-full pl-11 pr-4 py-3 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base appearance-none">
                                        <option value="tls">TLS</option>
                                        <option value="ssl">SSL</option>
                                        <option value="none">Güvenliksiz</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Test Mail Bilgileri -->
                    <div class="pt-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Test Mail Bilgileri</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="relative">
                                <label class="block text-sm sm:text-base font-medium text-gray-700 mb-2">Gönderici E-posta</label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-paper-plane text-gray-400"></i>
                                    </div>
                                    <input type="email" x-model="fromEmail" placeholder="gonderen@example.com" 
                                        class="block w-full pl-11 pr-4 py-3 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base" required>
                                </div>
                            </div>

                            <div class="relative">
                                <label class="block text-sm sm:text-base font-medium text-gray-700 mb-2">Alıcı E-posta</label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                    <input type="email" x-model="toEmail" placeholder="alici@example.com" 
                                        class="block w-full pl-11 pr-4 py-3 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" 
                        class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm sm:text-base font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300" 
                        :disabled="loading">
                        <i class="fas fa-spinner fa-spin mr-2" x-show="loading"></i>
                        <i class="fas fa-paper-plane mr-2" x-show="!loading"></i>
                        <span x-show="!loading">Bağlantıyı Test Et</span>
                        <span x-show="loading">Test Ediliyor...</span>
                    </button>
                </form>
                
                <template x-if="result">
                    <div class="mt-6 p-4 rounded-lg" 
                        :class="result.success ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200'">
                        <div class="flex items-center">
                            <i class="fas" 
                                :class="result.success ? 'fa-circle-check text-green-500' : 'fa-circle-xmark text-red-500'">
                            </i>
                            <p class="ml-2 text-sm sm:text-base" 
                                x-text="result.message" 
                                :class="result.success ? 'text-green-700' : 'text-red-700'">
                            </p>
                        </div>
                        <template x-if="result.logs">
                            <div class="mt-4">
                                <!-- Log Kontrol Butonları -->
                                <div class="flex justify-center md:justify-end space-x-2 mb-2">
                                    <button @click="navigator.clipboard.writeText(result.logs)"
                                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <i class="fas fa-copy mr-2"></i>
                                        Kopyala
                                    </button>
                                    <a :href="'data:text/plain;charset=utf-8,' + encodeURIComponent(result.logs)" 
                                       download="smtp-logs.txt"
                                       class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <i class="fas fa-download mr-2"></i>
                                        İndir
                                    </a>
                                </div>
                                <!-- Kaydırılabilir Log Alanı -->
                                <div class="relative">
                                    <pre class="bg-gray-800 text-gray-200 rounded-lg text-sm p-3 overflow-auto max-h-96" x-text="result.logs"></pre>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white bg-opacity-90 backdrop-blur-sm border-t border-gray-200 py-8 mt-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Üst Kısım -->
            <div class="text-center space-y-4 mb-8">
                <div class="flex items-center justify-center space-x-2">
                    <i class="fas fa-envelope-circle-check text-2xl text-indigo-600"></i>
                    <h3 class="text-xl font-bold text-gray-900">SMTP Mail Checker</h3>
                </div>
                <p class="text-gray-600 text-sm">
                    SMTP Mail Checker - AnkaSoft Yazılım & Alperen İrtik
                </p>
            </div>

            <!-- Sosyal Medya Linkleri -->
            <div class="flex flex-col items-center space-y-4 mb-8">
                <div class="flex justify-center space-x-4">
                    <a href="https://www.alperenirtik.com" target="_blank" 
                       class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 text-gray-600 hover:bg-indigo-100 hover:text-indigo-600 transition-all duration-300">
                        <i class="fas fa-globe text-lg"></i>
                    </a>
                    <a href="https://www.ankasoftyazilim.com" target="_blank"
                       class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 text-gray-600 hover:bg-indigo-100 hover:text-indigo-600 transition-all duration-300">
                        <i class="fas fa-building text-lg"></i>
                    </a>
                    <a href="https://github.com/alperenirtik" target="_blank"
                       class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 text-gray-600 hover:bg-indigo-100 hover:text-indigo-600 transition-all duration-300">
                        <i class="fab fa-github text-lg"></i>
                    </a>
                    <a href="https://www.linkedin.com/in/alperen-irtik-823564233/" target="_blank"
                       class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 text-gray-600 hover:bg-indigo-100 hover:text-indigo-600 transition-all duration-300">
                        <i class="fab fa-linkedin text-lg"></i>
                    </a>
                </div>
            </div>

            <!-- Alt Kısım -->
            <div class="pt-6 border-t border-gray-200">
                <p class="text-center text-gray-500 text-sm">
                    © 2024 SMTP Mail Checker - Örnek Github Projesidir. Açık kaynak kullanılabilir.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
