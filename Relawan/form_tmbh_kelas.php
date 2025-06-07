<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;300;400;500;600;700;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        roboto: ['"Roboto Slab"', 'serif'],
                    }
                }
            }
        }
</script>
<div id="modalTambahKelas" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
                <!-- Modal Header -->
                <div class="bg-ngajar-green text-white px-6 py-4 rounded-t-lg">
                    <h3 class="text-lg font-semibold">Buat Kelas</h3>
                </div>
                
                <!-- Modal Body -->
                <form id="formTambahKelas" class="p-6 space-y-4">
                    <!-- Nama Kelas -->
                    <div>
                        <label for="namaKelas" class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                        <input 
                            type="text" 
                            id="namaKelas" 
                            name="namaKelas" 
                            placeholder="Nama Kelas" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-ngajar-green focus:border-transparent"
                            required
                        >
                    </div>
                    
                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsiKelas" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea 
                            id="deskripsiKelas" 
                            name="deskripsiKelas" 
                            placeholder="Deskripsi Kelas" 
                            rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-ngajar-green focus:border-transparent resize-none"
                        ></textarea>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="kategoriKelas" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select 
                            id="kategoriKelas" 
                            name="kategoriKelas" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-ngajar-green focus:border-transparent"
                            required
                        >
                            <option value="">Pilih Kategori</option>
                            <option value="programming">Programming</option>
                            <option value="design">Design</option>
                            <option value="marketing">Marketing</option>
                            <option value="business">Business</option>
                            <option value="mathematics">Mathematics</option>
                            <option value="science">Science</option>
                            <option value="language">Language</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>

                    <!-- Durasi -->
                    <div>
                        <label for="durasiKelas" class="block text-sm font-medium text-gray-700 mb-2">Durasi (jam)</label>
                        <input 
                            type="number" 
                            id="durasiKelas" 
                            name="durasiKelas" 
                            placeholder="contoh: 120" 
                            min="1"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-ngajar-green focus:border-transparent"
                            required
                        >
                    </div>
                    
                    <!-- Modal Footer -->
                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                        <button 
                            type="button" 
                            id="batalBtn"
                            class="px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500"
                        >
                            Batal
                        </button>
                        <button 
                            type="submit"
                            class="px-4 py-2 bg-ngajar-green text-white rounded-md hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-ngajar-green"
                        >
                            Buat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script>
const modal = document.getElementById('modalTambahKelas');
        const tambahKelasBtn = document.getElementById('tambahKelasBtn');
        const batalBtn = document.getElementById('batalBtn');
        const formTambahKelas = document.getElementById('formTambahKelas');

        // Show modal
        tambahKelasBtn.addEventListener('click', function() {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        });

        // Hide modal
        function hideModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Restore scrolling
            formTambahKelas.reset(); // Reset form
        }

        // Hide on cancel button
        batalBtn.addEventListener('click', hideModal);

        // Hide on background click
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                hideModal();
            }
        });

        // Hide on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                hideModal();
            }
        });

        // Form submission
        formTambahKelas.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(formTambahKelas);
            const namaKelas = formData.get('namaKelas');
            const deskripsiKelas = formData.get('deskripsiKelas');
            const kategoriKelas = formData.get('kategoriKelas');
            
            // Here you would typically send the data to your server
            console.log('Data kelas baru:', {
                nama: namaKelas,
                deskripsi: deskripsiKelas,
                kategori: kategoriKelas,
            });
            
            // Show success message (you can customize this)
            alert('Kelas berhasil dibuat!');
            
            // Hide modal
            hideModal();
            
            // Here you could add the new class card to the grid
            // or refresh the page to show the new class
        });

        // Hamburger menu functionality
        document.getElementById('hamburgerButton').addEventListener('click', function() {
            // Add sidebar toggle functionality here
            console.log('Sidebar toggle clicked');
        });

        // Add hover effects and interactions
        document.querySelectorAll('.bg-ngajar-green, .bg-blue-500').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px)';
                this.style.transition = 'transform 0.2s ease';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
</script>