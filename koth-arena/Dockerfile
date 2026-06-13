FROM ubuntu:22.04

ENV DEBIAN_FRONTEND=noninteractive
# TAMBAHAN: jq untuk parser JSON di tracker
RUN apt-get update && apt-get install -y \
    openssh-server sudo vim net-tools cron \
    apache2 libapache2-mod-php iputils-ping curl jq

RUN a2enmod php* || true

RUN mkdir -p /var/run/sshd
RUN sed -i 's/#PermitRootLogin prohibit-password/PermitRootLogin no/' /etc/ssh/sshd_config
RUN sed -i 's/#PasswordAuthentication yes/PasswordAuthentication yes/' /etc/ssh/sshd_config

RUN useradd -m -s /bin/bash player && echo 'player:SuperSecretPlayerPass2026!' | chpasswd
RUN echo "NOBODY OWNS THIS HILL YET" > /root/king.txt && chmod 644 /root/king.txt
RUN chmod u+s /bin/bash

# Hapus index.html bawaan
RUN rm -f /var/www/html/index.html

# Copy file dari host ke container
COPY index.php /var/www/html/index.php
COPY db_config.php.bak /var/www/html/.db_config.php.bak
COPY scoreboard.php /var/www/html/scoreboard.php
COPY dashboard.php /var/www/html/dashboard.php
COPY koth-tracker.sh /usr/local/bin/koth-tracker.sh

RUN chown -R www-data:www-data /var/www/html/
RUN chmod +x /usr/local/bin/koth-tracker.sh

# Start script: Jalankan Tracker di background (&), lalu Apache & SSH
RUN echo '#!/bin/bash\n/usr/local/bin/koth-tracker.sh &\nservice apache2 start\n/usr/sbin/sshd -D' > /start.sh && chmod +x /start.sh
RUN mkdir -p /var/log/koth && chmod 777 /var/log/koth
RUN echo 'export PROMPT_COMMAND="echo \"\$(date +\%b \%d \%H:\%M:\%S) koth-arena bash: [\$(whoami)] executed: \$(history 1 | sed \"s/^[ ]*[0-9]\+[ ]*//\")\" >> /var/log/koth/commands.log"' >> /etc/bash.bashrc

EXPOSE 22 80
CMD ["/start.sh"]
