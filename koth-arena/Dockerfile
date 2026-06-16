FROM ubuntu:22.04

ENV DEBIAN_FRONTEND=noninteractive

# Install dependencies
RUN apt-get update && apt-get install -y \
    apache2 \
    php \
    libapache2-mod-php \
    openssh-server \
    sudo \
    jq \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Setup SSH
RUN mkdir /var/run/sshd
RUN echo 'root:SuperSecretRootPass2026!' | chpasswd

# Buat user 'player' untuk SSH Pivot
RUN groupadd -g 1001 player && \
    useradd -m -u 1001 -g player -s /bin/bash player && \
    echo 'player:SuperSecretPlayerPass2026!' | chpasswd

# Setup Web (CTF Target)
COPY index.php scoreboard.php vuln.php logger.php db_config.php.bak /var/www/html/
COPY koth-tracker.sh /usr/local/bin/koth-tracker
RUN rm -f /var/www/html/index.html

RUN echo '{"scores":{}, "winner":null}' > /var/www/html/scores.json && \
    echo '{"current_king":"NOBODY", "hold_time":0}' > /var/www/html/state.json && \
    chmod 644 /var/www/html/*.php /var/www/html/*.bak /var/www/html/*.json && \
    chmod 755 /usr/local/bin/koth-tracker && \
    chown root:root /var/www/html/*.php /var/www/html/*.bak && \
    chown www-data:www-data /var/www/html/*.json

# 🚨 FIX LOGIC FLAW: Hardening & Force Pivoting
# 1. Hapus semua SUID default yang bisa disalahgunakan www-data
RUN find / -xdev -perm /6000 -type f -exec chmod a-s {} + || true

# 2. Tanam "Loot" agar attacker (www-data) terpancing mencari password SSH
RUN chmod 644 /var/www/html/db_config.php.bak

# 3. Buat jalan Privesc HANYA untuk user 'player' (Bukan www-data)
# SUID pada script diabaikan Linux, jadi privshell harus binary.
RUN cp /bin/bash /usr/local/bin/privshell && \
    chown root:player /usr/local/bin/privshell && \
    chmod 4750 /usr/local/bin/privshell

# 4. Setup KotH King File
RUN echo "ez kid" > /root/king.txt && chmod 600 /root/king.txt

# Telemetry bridge for Wazuh/host log collection
RUN mkdir -p /var/log/koth && chmod 777 /var/log/koth && \
    sed -i 's#ErrorLog .*#ErrorLog /var/log/koth/apache-error.log#' /etc/apache2/sites-available/000-default.conf && \
    sed -i 's#CustomLog .* combined#CustomLog /var/log/koth/apache-access.log combined#' /etc/apache2/sites-available/000-default.conf && \
    sed -i 's/#PasswordAuthentication yes/PasswordAuthentication yes/' /etc/ssh/sshd_config && \
    sed -i 's/#PermitRootLogin prohibit-password/PermitRootLogin no/' /etc/ssh/sshd_config && \
    echo 'LogLevel VERBOSE' >> /etc/ssh/sshd_config && \
    echo 'export PROMPT_COMMAND='\''echo "$(date +%b\ %d\ %H:%M:%S) koth-arena bash: [$(whoami)] executed: $(history 1 | sed "s/^[ ]*[0-9]\+[ ]*//")" >> /var/log/koth/commands.log'\''' >> /etc/bash.bashrc

# Expose ports
EXPOSE 80 22

# Start services
CMD mkdir -p /var/log/koth && chmod 777 /var/log/koth && \
    touch /var/log/koth/apache-access.log /var/log/koth/apache-error.log /var/log/koth/ssh.log /var/log/koth/web-requests.log /var/log/koth/web-commands.log /var/log/koth/commands.log && \
    chmod 666 /var/log/koth/*.log && \
    /usr/sbin/sshd -E /var/log/koth/ssh.log && \
    /usr/local/bin/koth-tracker & \
    apache2ctl -D FOREGROUND
