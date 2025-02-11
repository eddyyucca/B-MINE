// server_email.js
const express = require('express');
const nodemailer = require('nodemailer');
const schedule = require('node-schedule');
const cors = require('cors');
const fs = require('fs').promises;
require('dotenv').config();

const app = express();

// Middleware
app.use(cors());
app.use(express.json());

// Konfigurasi email
const EMAIL_CONFIG = {
    targetEmail: 'eddyyucca@gmail.com',
    scheduleTime: '23:53'
};

// Konfigurasi SMTP
const transporter = nodemailer.createTransport({
    host: 'webmail.bukitmakmur.com',
    port: 587,
    secure: false, // TLS
    auth: {
        user: 'eddy.as@bukitmakmur.com',     // Ganti dengan email Outlook Anda
        pass: 'julaklanji123!@#'               // Ganti dengan password Anda
    },
    tls: {
        ciphers: 'SSLv3',
        rejectUnauthorized: false
    },
    debug: true, // Enable debugging
    logger: true // Tampilkan log
});

// Fungsi untuk menyimpan log
async function saveLog(logData) {
    const timestamp = new Date().toLocaleString('id-ID', { 
        timeZone: 'Asia/Makassar' 
    });
    const logEntry = `[${timestamp}] ${logData}\n`;
    
    try {
        await fs.appendFile('email_logs.txt', logEntry);
    } catch (error) {
        console.error('Error menyimpan log:', error);
    }
}

// Fungsi untuk mengirim email
const sendScheduledEmail = async () => {
    try {
        const currentTime = new Date().toLocaleString('id-ID', { 
            timeZone: 'Asia/Makassar',
            hour12: false 
        });
        
        const mailOptions = {
            from: 'eddy.as@bukitmakmur.com',
            to: EMAIL_CONFIG.targetEmail,
            subject: `Scheduled Report - ${currentTime}`,
            html: `
                <h1>Laporan Terjadwal</h1>
                <p>Ini adalah laporan yang dikirim secara otomatis.</p>
                <p>Waktu pengiriman: ${currentTime} WITA</p>
                <br>
                <p>Regards,</p>
                <p>Automated System</p>
            `
        };

        const info = await transporter.sendMail(mailOptions);
        
        // Log sukses
        const successLog = `
            Email berhasil terkirim!
            ID: ${info.messageId}
            Waktu: ${currentTime}
            Penerima: ${EMAIL_CONFIG.targetEmail}
            Status: Terkirim
            ------------------------------
        `;
        
        console.log('\x1b[32m%s\x1b[0m', successLog); // Warna hijau di console
        await saveLog(successLog);
        
        return {
            success: true,
            messageId: info.messageId,
            time: currentTime
        };

    } catch (error) {
        // Log error
        const errorLog = `
            GAGAL mengirim email!
            Waktu: ${new Date().toLocaleString('id-ID', { timeZone: 'Asia/Makassar' })}
            Error: ${error.message}
            ------------------------------
        `;
        
        console.error('\x1b[31m%s\x1b[0m', errorLog); // Warna merah di console
        await saveLog(errorLog);
        
        return {
            success: false,
            error: error.message
        };
    }
};

// Fungsi untuk mengatur jadwal
const startSchedule = () => {
    const [hours, minutes] = EMAIL_CONFIG.scheduleTime.split(':').map(Number);
    
    const rule = new schedule.RecurrenceRule();
    rule.hour = hours;
    rule.minute = minutes;
    rule.tz = 'Asia/Makassar';

    const job = schedule.scheduleJob(rule, async () => {
        console.log('\x1b[34m%s\x1b[0m', 'Menjalankan jadwal email...'); // Warna biru
        const result = await sendScheduledEmail();
        
        if (result.success) {
            console.log('\x1b[32m%s\x1b[0m', `✓ Email terjadwal berhasil terkirim! (${result.time})`);
        } else {
            console.error('\x1b[31m%s\x1b[0m', `✗ Gagal mengirim email terjadwal: ${result.error}`);
        }
    });

    return job;
};

// Route untuk test email
app.get('/test-email', async (req, res) => {
    console.log('\x1b[34m%s\x1b[0m', 'Mengirim test email...'); // Warna biru
    
    const result = await sendScheduledEmail();
    
    if (result.success) {
        res.json({
            success: true,
            message: 'Email berhasil terkirim!',
            details: {
                messageId: result.messageId,
                time: result.time,
                recipient: EMAIL_CONFIG.targetEmail
            }
        });
    } else {
        res.status(500).json({
            success: false,
            message: 'Gagal mengirim email',
            error: result.error
        });
    }
});

// Route untuk cek log
app.get('/logs', async (req, res) => {
    try {
        const logs = await fs.readFile('email_logs.txt', 'utf8');
        res.send(logs.split('\n').join('<br>'));
    } catch (error) {
        res.status(500).send('Belum ada log tersimpan');
    }
});

// Route untuk cek status
app.get('/', (req, res) => {
    const job = schedule.scheduledJobs[Object.keys(schedule.scheduledJobs)[0]];
    const nextInvocation = job ? job.nextInvocation() : null;

    res.json({
        status: 'running',
        targetEmail: EMAIL_CONFIG.targetEmail,
        scheduleTime: `${EMAIL_CONFIG.scheduleTime} WITA`,
        nextSchedule: nextInvocation ? 
            nextInvocation.toLocaleString('id-ID', {
                timeZone: 'Asia/Makassar',
                hour12: false
            }) : 'Tidak ada jadwal',
        lastCheck: new Date().toLocaleString('id-ID', { 
            timeZone: 'Asia/Makassar' 
        })
    });
});

// Start server
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log('\x1b[36m%s\x1b[0m', `Server berjalan di port ${PORT}`); // Warna cyan
    console.log('\x1b[36m%s\x1b[0m', `Email akan dikirim setiap hari jam ${EMAIL_CONFIG.scheduleTime} WITA`);
    startSchedule();
});