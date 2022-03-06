//api : MHczUHrzvBLV1HsUn5XkOIfvg_do21SJR

// masukkan token bot mu di sini
var token = 'token anda';

// buat objek baru kita kasih nama tg
var tg = new telegram.daftar(token);

var Utils = telegram.Utils;
// inisiasi awal  
// id chat dari channel / group tujuan
var chat_id =id_anda;

// --- akhir variabel ---


// --- akhir variabel ---


// membuat fungsi yang akan dijadikan trigger ketika form onSubmit
function responDariForm() {
    
  // isi pesan dikosongkan di awal
  var pesan = '';
  
  // ambil form aktif
  var form = FormApp.getActiveForm();
  
  // ambil semua data respon nya
  var formResponses = form.getResponses();
  
  // ambil data respon terakhir saja
  var respon = formResponses[formResponses.length-1];  
  var item = respon.getItemResponses();  
  
  // dapatkan email responder
  var email = respon.getRespondentEmail();
  
  // masukkan informasi Email ke pesan
  // bersihkan sekalian format teks dari email dari tags HTML
  pesan += "✉ "+Utils.clearHTML(email);
  
  // ambil waktunya, hasilnya bertipe angka jadi harus diubah ke String dulu
  
  var waktuStamp = respon.getTimestamp();
  var waktu =  Utilities.formatDate(waktuStamp, "Asia/Jakarta", "yyyy-MM-dd HH:mm:ss"); 
  
  pesan += "\n⏱ <code>"+Utils.clearHTML(waktu)+" WIB.</code>";
  
  
  // susun kalimat dari respon user
  // dengan format T(anya) dan J(awab)
  
  for (var i =0; i< item.length; i++) {
    
    // format pertanyaan
    var tanya = item[i].getItem().getTitle();
    // bersihkan pertanyaan dari tag HTML jika ada
    tanya = Utils.clearHTML( String(tanya));
    
    // format jawaban
    var jawab = item[i].getResponse();
    // bersihkan respon jawaban dari tag HTML jika ada
    jawab = Utils.clearHTML( String(jawab) );
    
    // susun pesannya
    pesan += '\n\n✅ <b>' + tanya  + "</b>\n💬 <code>"+ jawab + "</code>";
  }
  
  // kirim pesan yang telah tersusun ke channel Telegram
  return tg.kirimPesan(chat_id, pesan, 'HTML');
  
}


