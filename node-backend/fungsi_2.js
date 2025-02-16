const nodemailer = require('nodemailer');
const schedule = require('node-schedule');
const fs = require('fs').promises;
const mysql = require('mysql2');
require('dotenv').config();

// Database configuration
const dbConfig = {
    host: process.env.DB_HOST || '127.0.0.1',
    port: process.env.DB_PORT || 3307,
    user: process.env.DB_USERNAME || 'root',
    password: process.env.DB_PASSWORD || '',
    database: process.env.DB_DATABASE || 'bmine'
};

// Email configurations for different tasks
const EMAIL_CONFIG = {
    she: {
        targetEmail: 'eddy.as@bukitmakmur.com',
        ccEmail: ['dwi.suriananda@bukitmakmur.com', 'gigih.s@bukitmakmur.com'],
        scheduleTime: '10:58'
    },
    pjo: {
        targetEmail: 'eddy.as@bukitmakmur.com',
        ccEmail: ['dwi.suriananda@bukitmakmur.com', 'gigih.s@bukitmakmur.com'],
        scheduleTime: '11:56'
    },
    bec: {
        targetEmail: 'eddy.as@bukitmakmur.com',
        ccEmail: ['dwi.suriananda@bukitmakmur.com', 'gigih.s@bukitmakmur.com'],
        scheduleTime: '11:57'
    },
    // ktt: {
    //     targetEmail: 'eddy.as@bukitmakmur.com',
    //     ccEmail: ['dwi.suriananda@bukitmakmur.com', 'gigih.s@bukitmakmur.com'],
    //     scheduleTime: '10:47'
    // }
};

// SMTP configuration
const transporter = nodemailer.createTransport({
    host: 'webmail.bukitmakmur.com',
    port: 587,
    secure: false,
    auth: {
        user: 'eddy.as@bukitmakmur.com',
        pass: 'julaklanji123!@#'
    },
    tls: {
        ciphers: 'SSLv3',
        rejectUnauthorized: false
    },
    debug: true,
    logger: true
});

// Database query functions
const getTasksCount = {
    she: () => {
        return new Promise((resolve, reject) => {
            const connection = mysql.createConnection(dbConfig);
            connection.query(
                'SELECT COUNT(*) as count FROM data_req WHERE status = 1',
                (error, results) => {
                    connection.end();
                    if (error) {
                        reject(error);
                        return;
                    }
                    resolve(results[0].count);
                }
            );
        });
    },
    pjo: () => {
        return new Promise((resolve, reject) => {
            const connection = mysql.createConnection(dbConfig);
            connection.query(
                'SELECT COUNT(*) as count FROM data_req WHERE status = 2',
                (error, results) => {
                    connection.end();
                    if (error) {
                        reject(error);
                        return;
                    }
                    resolve(results[0].count);
                }
            );
        });
    },
    bec: () => {
        return new Promise((resolve, reject) => {
            const connection = mysql.createConnection(dbConfig);
            connection.query(
                'SELECT COUNT(*) as count FROM data_req WHERE status = 3',
                (error, results) => {
                    connection.end();
                    if (error) {
                        reject(error);
                        return;
                    }
                    resolve(results[0].count);
                }
            );
        });
    },
    // ktt: () => {
    //     return new Promise((resolve, reject) => {
    //         const connection = mysql.createConnection(dbConfig);
    //         connection.query(
    //             `SELECT 
    //                 SUM(CASE 
    //                     WHEN u.code = 'FSP' AND JSON_EXTRACT(d.ktt, '$.userArea') = 'no' 
    //                     THEN 1 ELSE 0 
    //                 END) as FSP_count,
    //                 SUM(CASE 
    //                     WHEN u.code = 'TJ' AND JSON_EXTRACT(d.ktt, '$.userArea') = 'no' 
    //                     THEN 1 ELSE 0 
    //                 END) as TJ_count,
    //                 SUM(CASE 
    //                     WHEN u.code = 'TA' AND JSON_EXTRACT(d.ktt, '$.userArea') = 'no' 
    //                     THEN 1 ELSE 0 
    //                 END) as TA_count,
    //                 SUM(CASE 
    //                     WHEN u.code = 'BT' AND JSON_EXTRACT(d.ktt, '$.userArea') = 'no' 
    //                     THEN 1 ELSE 0 
    //                 END) as BT_count,
    //                 COUNT(*) as total_count
    //             FROM data_req d
    //             JOIN unit_users uu ON d.unit_id = uu.id
    //             JOIN units u ON uu.unit_id = u.id
    //             WHERE d.status = 4 
    //             AND JSON_EXTRACT(d.ktt, '$.userArea') = 'no'`,
    //             (error, results) => {
    //                 connection.end();
    //                 if (error) {
    //                     reject(error);
    //                     return;
    //                 }
    //                 resolve({
    //                     FSP: results[0].FSP_count || 0,
    //                     TJ: results[0].TJ_count || 0,
    //                     TA: results[0].TA_count || 0,
    //                     BT: results[0].BT_count || 0,
    //                     total: results[0].total_count || 0
    //                 });
    //             }
    //         );
    //     });
    // }
};

// Log saving function
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

// Email sending function
const sendTaskEmail = async (taskType) => {
    try {
        const currentTime = new Date().toLocaleString('id-ID', { 
            timeZone: 'Asia/Makassar',
            hour12: false 
        });
        
        const currentDate = new Date().toLocaleDateString('id-ID', {
            timeZone: 'Asia/Makassar',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        const outstandingCount = await getTasksCount[taskType]();
        
        const taskNames = {
            she: 'SHE Tasks',
            pjo: 'PJO Tasks',
            bec: 'BEC Tasks',
            ktt: 'KTT Approval Tasks'
        };

        // Jika tidak ada task yang outstanding, tidak perlu kirim email
        if (
            (typeof outstandingCount === 'object' && outstandingCount.total === 0) ||
            (typeof outstandingCount === 'number' && outstandingCount === 0)
        ) {
            console.log('\x1b[33m%s\x1b[0m', `Tidak ada outstanding ${taskType.toUpperCase()} tasks. Email tidak dikirim.`);
            return {
                success: true,
                skipped: true,
                reason: 'No outstanding tasks'
            };
        }

        const mailOptions = {
            from: 'eddy.as@bukitmakmur.com',
            to: EMAIL_CONFIG[taskType].targetEmail,
            cc: EMAIL_CONFIG[taskType].ccEmail,
            subject: `B'Mine - ${taskNames[taskType]} Outstanding Report - ${currentDate}`,
            html: `
                <div style="font-family: Arial, sans-serif; padding: 20px;">
                    <h2 style="color: #333;">B'Mine - ${taskNames[taskType]} Daily Report</h2>
                    <p style="color: #666;">Tanggal: ${currentDate}</p>
                    <p style="color: #666;">Waktu: ${currentTime} WITA</p>
                    
                    <div style="background-color: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0;">
                        <h3 style="color: #dc3545; margin: 0;">Outstanding ${taskNames[taskType]}</h3>
                        ${taskType === 'ktt' ? `
                        <div style="margin-top: 15px;">
                            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                                <tr style="background-color: #f1f1f1;">
                                    <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Location</th>
                                    <th style="padding: 10px; text-align: center; border: 1px solid #ddd;">Outstanding Tasks</th>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; border: 1px solid #ddd;">Fajar Sakti Prima (FSP)</td>
                                    <td style="padding: 10px; text-align: center; border: 1px solid #ddd; font-weight: bold; color: #dc3545;">
                                        ${outstandingCount.FSP} tasks
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; border: 1px solid #ddd;">Tanur Jaya (TJ)</td>
                                    <td style="padding: 10px; text-align: center; border: 1px solid #ddd; font-weight: bold; color: #dc3545;">
                                        ${outstandingCount.TJ} tasks
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; border: 1px solid #ddd;">Tiwa Abadi (TA)</td>
                                    <td style="padding: 10px; text-align: center; border: 1px solid #ddd; font-weight: bold; color: #dc3545;">
                                        ${outstandingCount.TA} tasks
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; border: 1px solid #ddd;">Bara Tabang (BT)</td>
                                    <td style="padding: 10px; text-align: center; border: 1px solid #ddd; font-weight: bold; color: #dc3545;">
                                        ${outstandingCount.BT} tasks
                                    </td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;">Total</td>
                                    <td style="padding: 10px; text-align: center; border: 1px solid #ddd; font-weight: bold; color: #dc3545;">
                                        ${outstandingCount.total} tasks
                                    </td>
                                </tr>
                            </table>
                        </div>
                        ` : `
                        <p style="font-size: 24px; font-weight: bold; color: #dc3545; margin: 10px 0;">
                            ${typeof outstandingCount === 'object' ? outstandingCount.total : outstandingCount} tasks
                        </p>
                        `}
                    </div>
                    
                    <p style="color: #666; font-style: italic;">
                        * This is an automated report from B'Mine System
                    </p>
                    
                    <hr style="border: 1px solid #eee; margin: 20px 0;">
                    
                    <p style="color: #888; font-size: 12px;">
                        Please do not reply to this email. If you have any questions, 
                        please contact your system administrator.
                    </p>

                    <div style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #eee; color: #666; font-size: 12px; line-height: 1.5;">
                        <p style="margin: 0;">
                            <strong>SHE - IT IPR</strong><br>
                            PT. Bukit Makmur Mandiri Utama (BUMA)<br>
                            Coal Hauling Road FSP Km. 22 Umag Dian<br>
                            Tabang, Kab. Kutai Kartenagara, Kalimantan Timur 77314 - Indonesia<br>
                            Jobsite BUMA - INDONESIA PRATAMA
                        </p>
                    </div>
                </div>
            `
        };

        const info = await transporter.sendMail(mailOptions);
        
        const successLog = `
            ${taskNames[taskType]} Email berhasil terkirim!
            ID: ${info.messageId}
            Waktu: ${currentTime}
            Penerima: ${EMAIL_CONFIG[taskType].targetEmail}
            CC: ${EMAIL_CONFIG[taskType].ccEmail.join(', ')}
            Outstanding Tasks: ${outstandingCount}
            Status: Terkirim
            ------------------------------
        `;
        
        console.log('\x1b[32m%s\x1b[0m', successLog);
        await saveLog(successLog);
        
        return {
            success: true,
            messageId: info.messageId,
            time: currentTime,
            outstandingCount
        };

    } catch (error) {
        const errorLog = `
            GAGAL mengirim ${taskType.toUpperCase()} task email!
            Waktu: ${new Date().toLocaleString('id-ID', { timeZone: 'Asia/Makassar' })}
            Error: ${error.message}
            ------------------------------
        `;
        
        console.error('\x1b[31m%s\x1b[0m', errorLog);
        await saveLog(errorLog);
        
        return {
            success: false,
            error: error.message
        };
    }
};

// Schedule function
const startSchedule = () => {
    // Schedule for each task type
    Object.entries(EMAIL_CONFIG).forEach(([taskType, config]) => {
        const [hours, minutes] = config.scheduleTime.split(':').map(Number);
        const rule = new schedule.RecurrenceRule();
        rule.hour = hours;
        rule.minute = minutes;
        rule.tz = 'Asia/Makassar';

        schedule.scheduleJob(rule, async () => {
            console.log('\x1b[34m%s\x1b[0m', `Menjalankan jadwal email ${taskType.toUpperCase()}...`);
            const result = await sendTaskEmail(taskType);
            
            if (result.success) {
                if (result.skipped) {
                    console.log('\x1b[33m%s\x1b[0m', `⚪ Email ${taskType.toUpperCase()} tidak dikirim: ${result.reason}`);
                } else {
                    console.log('\x1b[32m%s\x1b[0m', `✓ Email ${taskType.toUpperCase()} terjadwal berhasil terkirim! (${result.time})`);
                }
            } else {
                console.error('\x1b[31m%s\x1b[0m', `✗ Gagal mengirim email ${taskType.toUpperCase()} terjadwal: ${result.error}`);
            }
        });
    });
};

// Start the schedules
console.log('\x1b[36m%s\x1b[0m', 'Starting B\'Mine Email Scheduler...');
Object.entries(EMAIL_CONFIG).forEach(([taskType, config]) => {
    console.log('\x1b[36m%s\x1b[0m', `Email ${taskType.toUpperCase()} akan dikirim setiap hari jam ${config.scheduleTime} WITA`);
});
startSchedule();