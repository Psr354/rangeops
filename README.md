# 🛡️ RangeOps: Enterprise Purple Team Cyber Range

![Docker](https://img.shields.io/badge/Docker-Compose-blue?logo=docker)
![Wazuh](https://img.shields.io/badge/Wazuh-SIEM%2FXDR-orange?logo=webauthn)
![Bash](https://img.shields.io/badge/Bash-Telemetry%20Bridge-green?logo=gnu-bash)
![License](https://img.shields.io/badge/License-MIT-yellow.svg)
![Status](https://img.shields.io/badge/Status-Active-success)

**RangeOps** is an enterprise-grade Purple Team homelab designed to simulate realistic Attack & Defense (A&D) scenarios. It bridges the gap between Red Team exploitation and Blue Team detection by integrating vulnerable Docker applications with a centralized **Wazuh SIEM/XDR** pipeline. 

This project specifically solves the critical "Docker blindspot" problem: monitoring interactive shell commands inside ephemeral containers without installing heavy agents, using a custom-built Telemetry Bridge.

---

## 🌟 Key Features

- **Docker Blindspot Bypass (Telemetry Bridge):** Captures interactive shell commands from isolated Docker containers and forwards them to the Wazuh Host using Docker Shared Volumes and Bash Shell Wrappers.
- **Custom SIEM Engineering:** Features custom OSRegex/PCRE2 decoders and Custom Rules (Level 3 to 14) designed to detect specific Kill-Chain milestones (e.g., SUID Privilege Escalation, Critical File Modification).
- **Isolated Attack Surfaces:** Curated vulnerable environments from Vulhub (Jenkins RCE, Tomcat WebDAV Bypass) and custom-built CTF boxes (KotH Arena).
- **Automated SOC Dashboard:** A lightweight PHP + Tailwind CSS Command Center for centralized infrastructure monitoring and Kill-Chain cheat sheets.
- **Zero-Trust Networking:** Full network isolation using ZeroTier SD-WAN to prevent vulnerable services from being exposed to the public internet.

---

## 🛠️ Tech Stack

| Category | Technology |
| :--- | :--- |
| **SIEM / XDR** | Wazuh 4.x (Manager, Indexer, Dashboard) |
| **Containerization** | Docker, Docker Compose |
| **Host OS** | Debian 13 (Trixie) / Ubuntu 22.04 LTS |
| **Networking** | ZeroTier (SD-WAN), UFW Firewall |
| **Telemetry** | Bash Scripting, `PROMPT_COMMAND`, Shared Volumes |
| **Web Dashboard** | PHP 8.x, Tailwind CSS, Apache2 |
| **Targets** | Vulhub, Custom Python/Bash CTF Boxes |

---

## 📋 Prerequisites

Before deploying RangeOps, ensure your host machine meets the following requirements:
- **OS:** Linux (Debian 12/13 or Ubuntu 22.04/24.04 LTS highly recommended).
- **Docker & Docker Compose:** Latest stable versions.
- **Git:** For cloning the repository.
- **Hardware:** Minimum 8GB RAM (16GB+ recommended for running Wazuh + Multiple Targets simultaneously).
- *(Optional)* **ZeroTier:** For secure remote access via a private mesh network.

---

## 🚀 Installation & Setup

### 1. Clone the Repository
```bash
git clone https://github.com/psr354/rangeops.git
cd rangeops
```

### 2. Deploy Wazuh SIEM (Single Node)
```bash
cd wazuh
docker compose up -d
# Wait 2-3 minutes for Wazuh Indexer and Dashboard to initialize
```

### 3. Deploy Target (Example: KotH Arena)
```bash
cd ../koth-arena
docker compose up -d --build
```

### 4. Configure Wazuh Agent & Custom Rules
Run the setup script to inject the Telemetry Bridge and Custom Decoders into the Wazuh Manager:
```bash
# On the host machine
sudo bash scripts/setup-wazuh-telemetry.sh
```
*(This script configures `/var/log/koth/` permissions, injects `local_decoder.xml`, and restarts the Wazuh Agent & Manager).*

---

## 🎯 Usage (Purple Team Scenario)

**1. Red Team (Attack):**
SSH into the target machine and execute a Privilege Escalation.
```bash
ssh player@<TARGET_IP> -p 2222
# Password: SuperSecretPlayerPass2026!

# Escalate privileges using SUID bash
bash -p
echo "RANGEOPS_PWNED" > /root/king.txt
```

**2. Blue Team (Defend & Detect):**
Open the Wazuh Dashboard (`https://<HOST_IP>:8443`) and navigate to **Threat Hunting**.
Use the following DQL query to view real-time detections:
```kql
rule.id: "100051" OR rule.id: "100052"
```
*Result: You will see Level 12 (Privilege Escalation) and Level 14 (King.txt Modified) alerts trigger in real-time, despite the attack occurring inside an isolated Docker container.*

---

## 📂 Folder Structure

```text
rangeops/
├── wazuh/                # Wazuh SIEM Docker Compose & Volume configs
├── koth-arena/           # Custom CTF Target (Apache, PHP, SSH, Telemetry Bridge)
│   ├── Dockerfile
│   ├── docker-compose.yml
│   └── koth-logs/        # Shared volume for Wazuh Agent
├── vulhub/               # Curated CVE targets (Jenkins, Tomcat, Redis)
├── dashboard/            # PHP source code for RangeOps Command Center
├── scripts/              # Automation scripts for setup and rule injection
├── assets/               # Screenshots and architecture diagrams
└── README.md
```

---

## 🤝 Contributing

Contributions are welcome! To add new Kill-Chains or Custom Wazuh Rules:
1. **Fork** this repository.
2. Create a new feature branch (`git checkout -b feature/new-cve-target`).
3. Commit your changes (`git commit -m 'feat: Add Redis CVE-2022-0543 Lua Sandbox Escape'`).
4. Push to the branch (`git push origin feature/new-cve-target`).
5. Open a **Pull Request** and include an explanation of the Attack Vector and the Detection Rule you created.

---

## 📄 License & Contact

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

**Maintainer:**
* **Azzam "psr" Azhim Muntazhar** (NR - Salazhar)
* 🏫 **SMKN 40 Jakarta**
* 🏆 **CTF Player** (Pwn, Web, Forensics/DFIR)
* 🌐 **GitHub:** [github.com/psr354](https://github.com/psr354)

---
> *"Security is not just about how to break things, but how to see what others cannot."*
